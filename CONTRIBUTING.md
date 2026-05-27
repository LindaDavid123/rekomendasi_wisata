# Contributing Guide

## 🤝 Contributing to Rekomendasi Wisata

Thank you for your interest in contributing! This guide explains how to contribute to the project.

---

## 📋 Code of Conduct

- Be respectful and inclusive
- Welcome to all skill levels
- Constructive feedback only
- No harassment or discrimination
- Report issues through GitHub

---

## 🚀 How to Contribute

### 1. Report Issues

Found a bug? Have a suggestion?

**Create an Issue**:

1. Go to **Issues** tab
2. Click **New Issue**
3. Choose template: Bug Report or Feature Request
4. Describe clearly:
   - What happened?
   - Expected vs actual behavior
   - Steps to reproduce (bugs)
   - Your environment (PHP/Python/OS versions)

**Good Bug Report Example**:

```markdown
## Bug: Rating Not Saved

### Description
When I submit a rating for an attraction, 
the form submits but the rating doesn't appear.

### Steps to Reproduce
1. Login as user
2. Go to Borobudur Temple page
3. Click 5-star rating
4. Submit
5. Page refreshes but rating is missing

### Expected Behavior
Rating should be saved and displayed immediately

### Environment
- PHP 8.2.1
- MySQL 10.4.32
- Chrome 120

### Logs
Error in /var/log/php_error.log: [error message here]
```

### 2. Fork & Clone

```bash
# Fork on GitHub (click "Fork" button)

# Clone your fork
git clone https://github.com/YOUR_USERNAME/rekomendasi-wisata.git
cd rekomendasi-wisata

# Add upstream remote
git remote add upstream https://github.com/ORIGINAL_OWNER/rekomendasi-wisata.git
```

### 3. Create Feature Branch

```bash
# Update from upstream
git fetch upstream
git checkout main
git merge upstream/main

# Create feature branch
git checkout -b feature/your-feature-name

# Example:
# git checkout -b feature/add-review-sorting
# git checkout -b fix/rating-validation
# git checkout -b docs/add-troubleshooting-guide
```

**Naming Convention**:
- `feature/feature-name` - New features
- `fix/bug-name` - Bug fixes
- `docs/doc-name` - Documentation
- `perf/optimization-name` - Performance improvements
- `refactor/refactoring-name` - Code refactoring

### 4. Make Changes

```bash
# Make your changes
nano application/controllers/Wisata.php

# Test locally
php -S localhost:8000

# Verify tests pass (if applicable)
python -m pytest python/tests/
```

### 5. Commit Changes

```bash
# View changes
git status
git diff

# Stage changes
git add .

# Commit with descriptive message
git commit -m "feat: Add review sorting by rating

- Implement sorting in Wisata controller
- Add UI dropdown for sort options
- Update database query to support sorting
- Tested with 100+ reviews"
```

**Commit Message Format**:

```
<type>: <subject>

<optional body explaining WHY and HOW>

<optional footer with issue reference>
```

**Types**:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation
- `style`: Code formatting (no functional change)
- `refactor`: Code restructuring
- `perf`: Performance improvement
- `test`: Adding tests
- `chore`: Build/config changes

### 6. Push & Create PR

```bash
# Push to your fork
git push origin feature/your-feature-name

# Visit GitHub and click "Compare & pull request"
# Or go to original repo → Pull Requests → New PR
```

**PR Description Template**:

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Performance improvement

## Testing
How was this tested?
- Tested locally with PHP 8.2
- Verified with MySQL database
- Checked in Chrome and Firefox

## Checklist
- [ ] Code follows style guidelines
- [ ] Comments added for complex logic
- [ ] Documentation updated
- [ ] No new warnings generated
- [ ] Tests added (if applicable)

## Related Issues
Closes #123

## Screenshots (if applicable)
[Paste screenshots here]
```

### 7. Respond to Review

The maintainer may request changes:

```bash
# Make requested changes
nano application/models/Wisata_model.php

# Commit with "review" message
git commit -m "review: Address feedback on sorting implementation

- Improved query efficiency
- Added index hint to database
- Added error handling for edge cases"

# Push updated changes
git push origin feature/your-feature-name
# (No need to create new PR, it updates automatically)
```

### 8. Merge

Once approved, your PR will be merged! 🎉

---

## 📦 Development Setup

### Local Environment

```bash
# Clone the repository
git clone https://github.com/yourusername/rekomendasi-wisata.git
cd rekomendasi-wisata

# Copy environment file
cp .env.example .env

# Update .env with local values
nano .env
# DB_HOST=localhost
# DB_USER=root
# DB_PASSWORD=your_password

# Install Python dependencies
cd python
python -m venv venv
source venv/bin/activate  # or venv\Scripts\activate on Windows
pip install -r requirements.txt

# Install PHP dependencies (if using Composer)
cd ..
composer install

# Import database
mysql -u root -p < rekomendasi_wisata.sql

# Start Python service
cd python
python app.py
# Output: Running on http://127.0.0.1:5000/

# Start PHP development server
cd ..
php -S localhost:8000

# Visit http://localhost:8000
```

### Running Tests

```bash
# Python tests (if available)
cd python
pytest tests/

# PHP tests (if using PHPUnit)
cd ..
./vendor/bin/phpunit

# Manual testing checklist
# - Test login/logout
# - Test recommendations
# - Test ratings
# - Test admin functions
```

---

## ✨ Code Style

### PHP Code

- PSR-12 standard
- 4-space indentation
- No trailing whitespace
- UTF-8 encoding

```php
<?php
// Good
public function get_recommendations($user_id, $count = 10)
{
    if (!$this->is_authenticated()) {
        return [];
    }
    
    $recommendations = $this->load_from_cache($user_id);
    if ($recommendations) {
        return $recommendations;
    }
    
    // Fetch from ML service
    $url = getenv('PYTHON_SERVICE_URL') . '/recommend';
    $data = ['user_id' => $user_id, 'n_recommendations' => $count];
    
    $response = $this->http_post($url, $data);
    $this->save_to_cache($user_id, $response);
    
    return $response;
}
```

### Python Code

- PEP 8 standard
- 4-space indentation
- Type hints recommended

```python
# Good
from typing import List, Dict

def get_recommendations(user_id: int, count: int = 10) -> List[Dict]:
    """
    Get personalized recommendations for user.
    
    Args:
        user_id: The user's ID
        count: Number of recommendations to return
        
    Returns:
        List of recommendation dictionaries
    """
    if not user_id or not isinstance(user_id, int):
        raise ValueError("user_id must be a positive integer")
    
    recommendations = cache.get(f"user_{user_id}")
    if recommendations:
        return recommendations
    
    # Fetch and cache
    recommendations = compute_recommendations(user_id, count)
    cache.set(f"user_{user_id}", recommendations, ttl=86400)
    
    return recommendations
```

### Comments

- Explain WHY, not WHAT
- Comment complex logic
- Use clear language

```php
// Bad
$x = $y * 0.6 + $z * 0.4;  // Multiply

// Good
// Hybrid score: 60% collaborative filtering + 40% content-based
$hybrid_score = $collaborative_score * 0.6 + $content_based_score * 0.4;
```

---

## 📚 Documentation Standards

### Markdown Formatting

- Use proper heading hierarchy
- Code blocks with language specified
- Tables for structured data
- Links with descriptive text

```markdown
# Main Heading

## Sub Heading

### Sub-sub Heading

Paragraph with **bold** and *italic* and `code`.

```php
// Code example
$variable = 123;
```

- List item 1
- List item 2

| Column 1 | Column 2 |
|----------|----------|
| Value 1  | Value 2  |

[Descriptive link text](https://example.com)
```

### Adding to Documentation

1. Edit relevant file in `/docs/`
2. Follow existing structure
3. Add examples
4. Add cross-references

---

## 🧪 Testing Guidelines

### What to Test

- New features work as intended
- Existing features still work (regression)
- Edge cases handled
- Error handling works
- Security considerations

### Manual Testing Checklist

```markdown
- [ ] Feature works in Chrome
- [ ] Feature works in Firefox
- [ ] Feature works on mobile
- [ ] Form validation works
- [ ] Error messages clear
- [ ] Database changes persisted
- [ ] Cache invalidated properly
- [ ] Performance acceptable
- [ ] No console errors
- [ ] No SQL errors
```

---

## 🔒 Security Considerations

When contributing, ensure:

- [ ] No hardcoded credentials
- [ ] Input validation present
- [ ] SQL injection prevention (use prepared statements)
- [ ] XSS prevention (escape output)
- [ ] CSRF protection (if applicable)
- [ ] Proper error handling (no sensitive info exposed)
- [ ] Authentication/authorization checked
- [ ] Rate limiting considered

---

## 🎯 PR Checklist Before Submitting

- [ ] Code follows style guidelines
- [ ] Comments added for complex logic
- [ ] No debug statements (var_dump, console.log)
- [ ] Documentation updated
- [ ] Tests pass locally
- [ ] No new warnings/errors
- [ ] Commits have meaningful messages
- [ ] Related issue referenced
- [ ] No merge conflicts
- [ ] Ready for production

---

## 📈 Contribution Ideas

### Easy (Good for First Contribution)

- [ ] Fix typos in documentation
- [ ] Add missing docstrings
- [ ] Improve code comments
- [ ] Add usage examples
- [ ] Create/improve tests
- [ ] Update README

### Medium

- [ ] Add new feature (see Issues)
- [ ] Fix reported bugs
- [ ] Improve performance
- [ ] Refactor code
- [ ] Add validation

### Advanced

- [ ] Deep ML algorithm improvements
- [ ] Architecture optimization
- [ ] Security hardening
- [ ] Scalability improvements
- [ ] New major features

---

## ❓ Questions?

- Check existing Issues and Discussions
- Read documentation in `/docs/`
- Open a Discussion on GitHub
- Contact maintainer

---

## 🙏 Thank You!

Thank you for contributing to Rekomendasi Wisata! Your help makes this project better. 🎉

