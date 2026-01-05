<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recommendation Helper
 * Helper functions untuk integrasi dengan Flask Recommendation API
 */

if (! function_exists('get_recommendations')) {
    /**
     * Get recommendations dari Flask API
     *
     * @param int $user_id User ID
     * @param string $method Method: collaborative, content_based, hybrid
     * @param int $k Jumlah nearest neighbors
     * @param int $n_recommendations Jumlah rekomendasi yang diinginkan
     * @param float $alpha Bobot collaborative (untuk hybrid)
     * @return array|false
     */
    function get_recommendations($user_id, $method = 'hybrid', $k = 5, $n_recommendations = 10, $alpha = 0.6)
    {
        $api_url = 'http://localhost:5000/recommend';

        $data = [
            'user_id'           => (int) $user_id,
            'method'            => $method,
            'k'                 => (int) $k,
            'n_recommendations' => (int) $n_recommendations,
            'alpha'             => (float) $alpha,
        ];

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error     = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Recommendation API Error: ' . $error);
            return false;
        }

        if ($http_code != 200) {
            log_message('error', 'Recommendation API HTTP Error: ' . $http_code);
            return false;
        }

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] == 'success') {
            return $result['recommendations'];
        }

        return false;
    }
}

if (! function_exists('get_similar_wisata')) {
    /**
     * Get similar wisata dari Flask API
     *
     * @param int $wisata_id Wisata ID
     * @param int $k Jumlah wisata similar
     * @return array|false
     */
    function get_similar_wisata($wisata_id, $k = 10)
    {
        $api_url = 'http://localhost:5000/similar-wisata';

        $data = [
            'wisata_id' => (int) $wisata_id,
            'k'         => (int) $k,
        ];

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error     = curl_error($ch);
        curl_close($ch);

        if ($error || $http_code != 200) {
            return false;
        }

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] == 'success') {
            return $result['similar_items'];
        }

        return false;
    }
}

if (! function_exists('refresh_recommendation_cache')) {
    /**
     * Refresh cache di Flask API
     *
     * @return bool
     */
    function refresh_recommendation_cache()
    {
        $api_url = 'http://localhost:5000/refresh-cache';

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $result = json_decode($response, true);
            return isset($result['status']) && $result['status'] == 'success';
        }

        return false;
    }
}

if (! function_exists('get_recommendation_stats')) {
    /**
     * Get statistics dari Flask API
     *
     * @return array|false
     */
    function get_recommendation_stats()
    {
        $api_url = 'http://localhost:5000/stats';

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $result = json_decode($response, true);
            if (isset($result['status']) && $result['status'] == 'success') {
                return $result['statistics'];
            }
        }

        return false;
    }
}

if (! function_exists('check_recommendation_api')) {
    /**
     * Check apakah Flask API running
     *
     * @return bool
     */
    function check_recommendation_api()
    {
        $api_url = 'http://localhost:5000/';

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200;
    }
}
