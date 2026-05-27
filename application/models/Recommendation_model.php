<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Recommendation Model
 * Implements Hybrid Collaborative + Item-Based Filtering
 */
class Recommendation_model extends CI_Model {
    
    private $similarity_table = 'similarity_cache';
    private $history_table = 'recommendation_history';
    
    /**
     * Get hybrid recommendations (combines collaborative and item-based filtering)
     */
    public function get_hybrid_recommendations($user_id, $limit = 12) {
        // Get collaborative filtering recommendations
        $collaborative = $this->get_collaborative_recommendations($user_id, $limit);
        
        // Get item-based recommendations
        $item_based = $this->get_item_based_recommendations($user_id, $limit);
        
        // Merge and sort by score
        $recommendations = [];
        
        // Add collaborative recommendations with weight 0.6
        foreach ($collaborative as $item) {
            $wisata_id = $item['id'];
            $predicted_rating = isset($item['predicted_rating']) ? $item['predicted_rating'] : 0;
            $recommendations[$wisata_id] = [
                'wisata' => $item,
                'score' => $predicted_rating * 0.6,
                'recommendation_score' => $predicted_rating * 0.6
            ];
        }
        
        // Add item-based recommendations with weight 0.4
        foreach ($item_based as $item) {
            $wisata_id = $item['id'];
            $similarity_score = isset($item['similarity_score']) ? $item['similarity_score'] : 0;
            if (isset($recommendations[$wisata_id])) {
                $recommendations[$wisata_id]['score'] += $similarity_score * 0.4;
                $recommendations[$wisata_id]['recommendation_score'] = $recommendations[$wisata_id]['score'];
            } else {
                $recommendations[$wisata_id] = [
                    'wisata' => $item,
                    'score' => $similarity_score * 0.4,
                    'recommendation_score' => $similarity_score * 0.4
                ];
            }
        }
        
        // Sort by score descending
        uasort($recommendations, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Extract wisata data and limit
        $result = [];
        foreach ($recommendations as $rec) {
            $wisata = $rec['wisata'];
            $wisata['recommendation_score'] = isset($rec['recommendation_score']) ? $rec['recommendation_score'] : $rec['score'];
            $result[] = $wisata;
            if (count($result) >= $limit) break;
        }
        
        // Save to history
        if (!empty($result)) {
            $this->save_recommendation_history($user_id, 'hybrid', array_column($result, 'id'));
        }
        
        return $result;
    }
    
    /**
     * Get collaborative filtering recommendations
     * Based on similar users' preferences
     */
    public function get_collaborative_recommendations($user_id, $limit = 10) {
        // Get user's ratings
        $user_ratings = $this->get_user_rating_vector($user_id);
        
        if (empty($user_ratings)) {
            return $this->get_popular_wisata($limit);
        }
        
        // Find similar users
        $similar_users = $this->find_similar_users($user_id, $user_ratings);
        
        if (empty($similar_users)) {
            return $this->get_popular_wisata($limit);
        }
        
        // Get wisata rated by similar users but not by current user
        $recommendations = [];
        $rated_wisata_ids = array_keys($user_ratings);
        
        foreach ($similar_users as $similar_user) {
            $user_id_similar = $similar_user['user_id'];
            $similarity = $similar_user['similarity'];
            
            // Get ratings from similar user
            $this->db->select('wisata_id, rating');
            $this->db->where('user_id', $user_id_similar);
            $this->db->where_not_in('wisata_id', $rated_wisata_ids);
            $similar_user_ratings = $this->db->get('rating')->result_array();
            
            foreach ($similar_user_ratings as $rating) {
                $wisata_id = $rating['wisata_id'];
                
                if (!isset($recommendations[$wisata_id])) {
                    $recommendations[$wisata_id] = [
                        'wisata_id' => $wisata_id,
                        'weighted_sum' => 0,
                        'similarity_sum' => 0
                    ];
                }
                
                $recommendations[$wisata_id]['weighted_sum'] += $rating['rating'] * $similarity;
                $recommendations[$wisata_id]['similarity_sum'] += $similarity;
            }
        }
        
        // Calculate predicted ratings
        foreach ($recommendations as $wisata_id => &$rec) {
            if ($rec['similarity_sum'] > 0) {
                $rec['predicted_rating'] = 
                $rec['weighted_sum'] / $rec['similarity_sum'];
            } else {
                $rec['predicted_rating'] = 0;
            }
        }
        
        // Sort by predicted rating
        uasort($recommendations, function($a, $b) {
            return $b['predicted_rating'] <=> $a['predicted_rating'];
        });
        
        // Get wisata details
        $wisata_ids = array_slice(array_keys($recommendations), 0, $limit);
        
        if (empty($wisata_ids)) {
            return $this->get_popular_wisata($limit);
        }
        
        $this->db->where_in('id', $wisata_ids);
        $wisata_list = $this->db->get('wisata')->result_array();
        
        // Add predicted ratings
        foreach ($wisata_list as &$wisata) {
            $wisata['predicted_rating'] = $recommendations[$wisata['id']]['predicted_rating'];
        }
        
        return $wisata_list;
    }
    
    /**
     * Get item-based recommendations
     * Based on similar items to what user rated, weighted by rating score
     */
    public function get_item_based_recommendations($user_id, $limit = 10) {
        // Get all wisata that user has rated
        $this->db->select('wisata_id, rating');
        $this->db->where('user_id', $user_id);
        $user_ratings = $this->db->get('rating')->result_array();
        
        if (empty($user_ratings)) {
            return $this->get_popular_wisata($limit);
        }
        
        // Get all rated wisata IDs
        $rated_wisata_ids = array_column($user_ratings, 'wisata_id');
        
        // Find similar wisata based on all ratings (1-5)
        $recommendations = [];
        
        foreach ($user_ratings as $rating_data) {
            $wisata_id = $rating_data['wisata_id'];
            $rating_score = $rating_data['rating'];
            
            // Find similar wisata using cosine similarity
            $similar = $this->find_similar_wisata($wisata_id, $rated_wisata_ids);
            
            foreach ($similar as $item) {
                $similar_wisata_id = $item['wisata_id_2'];
                
                if (!isset($recommendations[$similar_wisata_id])) {
                    $recommendations[$similar_wisata_id] = 0;
                }
                
                // Weight similarity by user's rating score
                // Higher ratings give more weight to similar items
                $weighted_similarity = $item['similarity_score'] * ($rating_score / 5.0);
                $recommendations[$similar_wisata_id] += $weighted_similarity;
            }
        }
        
        // Sort by weighted similarity score
        arsort($recommendations);
        
        // Get wisata details
        $wisata_ids = array_slice(array_keys($recommendations), 0, $limit);
        
        if (empty($wisata_ids)) {
            return $this->get_popular_wisata($limit);
        }
        
        $this->db->where_in('id', $wisata_ids);
        $wisata_list = $this->db->get('wisata')->result_array();
        
        // Add similarity scores
        foreach ($wisata_list as &$wisata) {
            $wisata['similarity_score'] = $recommendations[$wisata['id']];
        }
        
        return $wisata_list;
    }
    
    /**
     * Calculate cosine similarity between two rating vectors
     */
    private function cosine_similarity($vector1, $vector2) {
        $dot_product = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;
        
        $common_items = array_intersect_key($vector1, $vector2);
        
        if (empty($common_items)) {
            return 0;
        }
        
        foreach ($common_items as $item => $value) {
            $dot_product += $vector1[$item] * $vector2[$item];
        }
        
        foreach ($vector1 as $value) {
            $magnitude1 += $value * $value;
        }
        
        foreach ($vector2 as $value) {
            $magnitude2 += $value * $value;
        }
        
        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);
        
        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }
        
        return $dot_product / ($magnitude1 * $magnitude2);
    }
    
    /**
     * Get user's rating vector
     */
    private function get_user_rating_vector($user_id) {
        $this->db->select('wisata_id, rating');
        $this->db->where('user_id', $user_id);
        $ratings = $this->db->get('rating')->result_array();
        
        $vector = [];
        foreach ($ratings as $rating) {
            $vector[$rating['wisata_id']] = $rating['rating'];
        }
        
        return $vector;
    }
    
    /**
     * Find similar users using cosine similarity
     */
    private function find_similar_users($user_id, $user_ratings, $limit = 10) {
        // Get all other users who have ratings
        $this->db->distinct();
        $this->db->select('user_id');
        $this->db->where('user_id !=', $user_id);
        $users = $this->db->get('rating')->result_array();
        
        $similarities = [];
        
        foreach ($users as $user) {
            $other_user_id = $user['user_id'];
            $other_ratings = $this->get_user_rating_vector($other_user_id);
            
            $similarity = $this->cosine_similarity($user_ratings, $other_ratings);
            
            if ($similarity > 0) {
                $similarities[] = [
                    'user_id' => $other_user_id,
                    'similarity' => $similarity
                ];
            }
        }
        
        // Sort by similarity descending
        usort($similarities, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });
        
        return array_slice($similarities, 0, $limit);
    }
    
    /**
     * Find similar wisata based on user ratings
     */
    private function find_similar_wisata($wisata_id, $exclude_ids = [], $limit = 5) {
        // Check cache first
        $this->db->where('wisata_id_1', $wisata_id);
        if (!empty($exclude_ids)) {
            $this->db->where_not_in('wisata_id_2', $exclude_ids);
        }
        $this->db->order_by('similarity_score', 'DESC');
        $this->db->limit($limit);
        $cached = $this->db->get($this->similarity_table)->result_array();
        
        if (!empty($cached)) {
            return $cached;
        }
        
        // Calculate similarity if not cached
        $this->calculate_wisata_similarities($wisata_id);
        
        // Retry from cache
        $this->db->where('wisata_id_1', $wisata_id);
        if (!empty($exclude_ids)) {
            $this->db->where_not_in('wisata_id_2', $exclude_ids);
        }
        $this->db->order_by('similarity_score', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->similarity_table)->result_array();
    }
    
    /**
     * Calculate and cache wisata similarities
     */
    private function calculate_wisata_similarities($wisata_id) {
        // Get all users who rated this wisata
        $this->db->select('user_id, rating');
        $this->db->where('wisata_id', $wisata_id);
        $wisata_ratings = $this->db->get('rating')->result_array();
        
        if (empty($wisata_ratings)) {
            return;
        }
        
        // Create rating vector
        $wisata_vector = [];
        foreach ($wisata_ratings as $rating) {
            $wisata_vector[$rating['user_id']] = $rating['rating'];
        }
        
        // Get all other wisata
        $this->db->select('id');
        $this->db->where('id !=', $wisata_id);
        $other_wisata = $this->db->get('wisata')->result_array();
        
        foreach ($other_wisata as $other) {
            $other_wisata_id = $other['id'];
            
            // Get ratings for other wisata
            $this->db->select('user_id, rating');
            $this->db->where('wisata_id', $other_wisata_id);
            $other_ratings = $this->db->get('rating')->result_array();
            
            $other_vector = [];
            foreach ($other_ratings as $rating) {
                $other_vector[$rating['user_id']] = $rating['rating'];
            }
            
            // Calculate similarity
            $similarity = $this->cosine_similarity($wisata_vector, $other_vector);
            
            if ($similarity > 0) {
                // Save to cache
                $data = [
                    'wisata_id_1' => $wisata_id,
                    'wisata_id_2' => $other_wisata_id,
                    'similarity_score' => $similarity
                ];
                
                $this->db->replace($this->similarity_table, $data);
            }
        }
    }
    
    /**
     * Get popular wisata as fallback
     */
    private function get_popular_wisata($limit = 10) {
        $this->db->order_by('rating_avg', 'DESC');
        $this->db->order_by('jumlah_rating', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('wisata')->result_array();
    }
    
    /**
     * Save recommendation history
     */
    private function save_recommendation_history($user_id, $type, $wisata_ids = array()) {
        if (empty($wisata_ids) || !is_array($wisata_ids)) {
            return false;
        }
        
        // Insert one record per wisata with recommendation score
        foreach ($wisata_ids as $wisata_id) {
            $data = array(
                'user_id' => $user_id,
                'wisata_id' => $wisata_id,
                'recommendation_type' => $type,
                'recommendation_score' => 0.0,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert($this->history_table, $data);
        }
        
        return true;
    }
    
    /**
     * Get recommendation history
     */
    public function get_history($user_id, $limit = 10) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->history_table)->result_array();
    }
}
