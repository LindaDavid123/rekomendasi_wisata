# Pre-Publish Checklist

## ✅ Complete Verification Before Publishing to GitHub

Use this checklist to ensure your project is production-ready before pushing to GitHub.

---

## 🗑️ Phase 1: Cleanup (CRITICAL)

### File Cleanup

- [ ] Deleted all session cache files (`application/cache/ci_session*`)
- [ ] Deleted all log files (`application/logs/*`)
- [ ] Deleted `__pycache__/` directories
- [ ] Removed temporary upload files
- [ ] No `.DS_Store` files
- [ ] No `Thumbs.db` files
- [ ] No IDE config files (.vscode/, .idea/)

**Verification Command**:
```bash
git status
# Should show no unexpected files
```

### Configuration Files

- [ ] `.env` file NOT tracked (only `.env.example`)
- [ ] Database credentials in `.env.example` as placeholders
- [ ] No hardcoded API keys in source files
- [ ] No hardcoded database passwords
- [ ] Google OAuth credentials not exposed
- [ ] Email passwords not hardcoded

**Verification**:
```bash
grep -r "password=" --include="*.php" --include="*.py" .
# Should return NO results with actual passwords
```

### Credentials Check

- [ ] No MySQL passwords in config files
- [ ] No API keys in Python app
- [ ] No Google client secrets
- [ ] No email credentials
- [ ] No JWT tokens
- [ ] No database dump files with data

**Search for common patterns**:
```bash
grep -r "password" . --include="*.php"
grep -r "secret" . --include="*.py"
grep -r "api_key" . --include="*.php" --include="*.py"
```

---

## 🔒 Phase 2: Security Review

### General Security

- [ ] SQL injection prevention in all queries
- [ ] XSS prevention in output
- [ ] CSRF token validation present
- [ ] Input validation implemented
- [ ] Error messages don't expose sensitive info
- [ ] Debug mode is OFF in production config
- [ ] No database credentials in error messages

### Authentication

- [ ] Passwords are hashed (bcrypt, not plain)
- [ ] Sessions expire properly
- [ ] Session fixation prevention
- [ ] OAuth properly configured
- [ ] Password reset functionality secure
- [ ] Account lockout after failed attempts

### File Upload

- [ ] File type validation
- [ ] File size limits
- [ ] Uploaded files outside web root
- [ ] No executable file uploads allowed
- [ ] Proper permissions on upload directory

**Verification**:
```bash
# Check for file upload validation
grep -r "move_uploaded_file" . --include="*.php"
grep -r "$_FILES" . --include="*.php"
```

---

## 📊 Phase 3: Code Quality

### PHP Code

- [ ] No `var_dump()` or `print_r()` debugging left
- [ ] No commented-out code
- [ ] Proper error handling
- [ ] Constants used instead of magic strings/numbers
- [ ] Consistent indentation (4 spaces)
- [ ] No trailing whitespace
- [ ] PSR-12 standards followed

**Check for debug statements**:
```bash
grep -r "var_dump\|print_r\|exit\|die" . --include="*.php"
# Should return ZERO results
```

### Python Code

- [ ] PEP 8 compliance
- [ ] No debug print statements
- [ ] Proper logging instead of prints
- [ ] Type hints where applicable
- [ ] Docstrings for functions
- [ ] Error handling implemented
- [ ] No hardcoded values

**Check style**:
```bash
pip install pylint flake8
flake8 python/
pylint python/
```

### Comments & Documentation

- [ ] Complex logic has comments
- [ ] Functions have docstrings
- [ ] Classes documented
- [ ] TODO comments resolved
- [ ] No placeholder comments like "fix this"

---

## 🗄️ Phase 4: Database

### Database Schema

- [ ] Database backup verified
- [ ] Schema properly normalized
- [ ] Indexes created for performance
- [ ] Foreign key constraints present
- [ ] Check constraints for data validity
- [ ] Default values sensible
- [ ] Column types correct
- [ ] NOT NULL constraints appropriate

**Export schema for verification**:
```bash
mysqldump -u root -p --no-data rekomendasi_wisata > schema.sql
# Review schema.sql
```

### Sample Data

- [ ] No production user data
- [ ] No real email addresses
- [ ] No real passwords
- [ ] Sample data has reasonable values
- [ ] Enough data for testing recommendations

---

## 📝 Phase 5: Documentation

### README.md

- [ ] Complete and professional
- [ ] Clear problem statement
- [ ] Solution overview
- [ ] Feature list accurate
- [ ] Tech stack listed
- [ ] Installation steps clear
- [ ] Quick start provided
- [ ] Screenshots included
- [ ] Screenshots have captions
- [ ] Contact/social links correct
- [ ] No broken links
- [ ] Badges display correctly

**Check for broken links**:
```bash
# Manually verify all links work
# Or use link checker tool
```

### Documentation Files

- [ ] `docs/01_architecture.md` - Complete ✅
- [ ] `docs/02_recommendation_system.md` - Complete ✅
- [ ] `docs/03_database_design.md` - Complete ✅
- [ ] `docs/04_deployment_guide.md` - Complete ✅
- [ ] `docs/05_api.md` - Complete ✅
- [ ] `CONTRIBUTING.md` - Created
- [ ] `CODE_OF_CONDUCT.md` - Created (optional)
- [ ] `TROUBLESHOOTING.md` - Created

**Check markdown formatting**:
```bash
# All .md files should be valid markdown
ls -la docs/*.md
```

### Comments in Code

- [ ] Meaningful comments (not obvious)
- [ ] Comments explain WHY, not WHAT
- [ ] No outdated comments
- [ ] Multi-line comments on complex logic

---

## 🎨 Phase 6: Aesthetics & Organization

### Folder Structure

- [ ] Organized logically
- [ ] No unnecessary nested folders
- [ ] Assets properly categorized
- [ ] Documentation in `/docs/`
- [ ] Screenshots in `/screenshots/`
- [ ] Database schema in `/database/`
- [ ] Clear README in each major folder

**Visual inspection**:
```bash
tree -L 2 -a
# Review structure, ensure it looks clean
```

### File Naming

- [ ] Consistent naming convention
- [ ] Controllers: PascalCase (e.g., Rekomendasi.php)
- [ ] Models: PascalCase with _model (e.g., User_model.php)
- [ ] Functions: snake_case (e.g., get_recommendations())
- [ ] Variables: snake_case
- [ ] Classes: PascalCase
- [ ] No spaces in filenames
- [ ] No special characters in names

### Asset Quality

- [ ] Images properly sized and compressed
- [ ] Screenshots have descriptive names
- [ ] Icons/logos high quality
- [ ] CSS/JS minified (optional for portfolio)
- [ ] No broken image links

---

## 🧪 Phase 7: Testing

### Functional Testing

- [ ] Homepage loads correctly
- [ ] Authentication works (login/register)
- [ ] User profile page works
- [ ] Recommendations display correctly
- [ ] Rating system works
- [ ] Favorites system works
- [ ] Admin dashboard accessible
- [ ] Search/filter functional
- [ ] No JavaScript errors in console

**Test in browser**:
```
F12 → Console tab
# Should be clean with no red errors
```

### Python Service Testing

- [ ] Service starts without errors
- [ ] API endpoints respond
- [ ] Recommendations generated correctly
- [ ] Cache works
- [ ] Error handling works
- [ ] Database connectivity verified

**Test endpoints**:
```bash
curl http://localhost:5000/
curl -X POST http://localhost:5000/recommend \
  -H "Content-Type: application/json" \
  -d '{"user_id": 1}'
```

### Database Testing

- [ ] All tables present
- [ ] Sample data loads correctly
- [ ] Foreign key relationships work
- [ ] Queries execute without errors
- [ ] Indexes exist and work
- [ ] Transaction support working

```bash
mysql -u root -p rekomendasi_wisata -e "SHOW TABLES;"
mysql -u root -p rekomendasi_wisata -e "SELECT COUNT(*) FROM users;"
```

---

## 🔗 Phase 8: Git Preparation

### Git Repository

- [ ] `.gitignore` complete and correct
- [ ] No sensitive files tracked
- [ ] No large binaries (>100MB)
- [ ] Repository clean (no staged changes)
- [ ] Initial commit message professional
- [ ] Branch structure clean

**Verify git status**:
```bash
git status
# Should show "working tree clean"
```

### Commit History

- [ ] Meaningful commit messages
- [ ] Logical commit organization
- [ ] No "WIP" or "test" commits visible
- [ ] Commits grouped by feature/fix

**Clean up if needed**:
```bash
git reset --soft HEAD~N
git commit -m "feat: Complete project setup"
```

### .gitignore Verification

- [ ] Cache files ignored
- [ ] Session files ignored
- [ ] `.env` ignored (only `.env.example` tracked)
- [ ] `__pycache__/` ignored
- [ ] `node_modules/` ignored (if applicable)
- [ ] IDE files ignored
- [ ] OS files ignored

**Test .gitignore**:
```bash
echo "test_ignore" > .test_file
git add -A
git status
# .test_file should NOT appear
rm .test_file
```

---

## 👀 Phase 9: Final Visual Check

### README Preview

- [ ] Renders correctly on GitHub
- [ ] Badges display properly
- [ ] Screenshots visible
- [ ] Code examples formatted correctly
- [ ] Tables render properly
- [ ] Links clickable

**Preview locally** (install grip):
```bash
pip install grip
grip README.md
# Visit http://localhost:6419
```

### Repository Landing Page

- [ ] Description is clear
- [ ] Topics assigned (5-10)
- [ ] Repository is public
- [ ] Appears professional
- [ ] No warning badges

---

## 📋 Phase 10: Final Verification

### Content Verification

- [ ] No personal information exposed
- [ ] No company secrets
- [ ] No copyrighted content
- [ ] No external links to personal sites (unless intended)
- [ ] Contact information appropriate
- [ ] Social links correct

### License

- [ ] LICENSE file present
- [ ] MIT License content correct
- [ ] Year and name updated
- [ ] Mentioned in README

### Environment

- [ ] `.env.example` has all required variables
- [ ] `.env.example` has placeholder values
- [ ] `.env.example` has helpful comments
- [ ] `.env` NOT tracked

---

## 🎯 Pre-Push Checklist

Before final push:

```bash
# 1. Ensure everything is committed
git status
# Should show "working tree clean"

# 2. Verify no secrets exposed
git ls-files | xargs grep -l "password="
git ls-files | xargs grep -l "secret"
# Should show ZERO results

# 3. Check for large files
find . -size +5M
# Should be ZERO

# 4. Verify .gitignore works
git ls-files | grep -E "\.env$|__pycache__|\.cache"
# Should show ZERO results

# 5. Final status check
git log --oneline -5
# Should show meaningful commit messages
```

---

## 🚀 Go/No-Go Decision

### GO TO PUBLISH IF:

- ✅ All cleanup phases passed
- ✅ Security review passed
- ✅ Code quality verified
- ✅ Database correct
- ✅ Documentation complete
- ✅ Testing successful
- ✅ Git prepared
- ✅ No sensitive data exposed

### DON'T PUBLISH IF:

- ❌ Credentials exposed anywhere
- ❌ Debug mode enabled
- ❌ Broken links in docs
- ❌ No README
- ❌ Spelling errors
- ❌ Untested code
- ❌ Large files (>5MB)
- ❌ Uncertain about quality

---

## 📊 Final Sign-Off

```
Date: _______________
Reviewer: _______________

All phases completed: ☐ YES ☐ NO
Ready to publish: ☐ YES ☐ NO

Comments: _________________________________
```

---

## ✨ After Publishing

1. ✅ Announce on social media
2. ✅ Share in relevant communities
3. ✅ Pin repository to GitHub profile
4. ✅ Add to portfolio website
5. ✅ Monitor for issues
6. ✅ Respond to stars/forks
7. ✅ Keep documentation updated

