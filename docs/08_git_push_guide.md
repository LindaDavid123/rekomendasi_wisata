# Git Push: Step-by-Step Guide

## 🚀 Complete Guide to Push Your Project to GitHub

This guide walks through pushing your project to GitHub for the first time.

---

## 📋 Prerequisites

Before you start, ensure:

1. **Git installed**
   ```bash
   git --version
   # Should show version 2.0+
   ```

2. **GitHub account created**
   - Visit https://github.com/signup
   - Verify email

3. **SSH or HTTPS configured**
   - Choose one authentication method (see below)

4. **Project cleaned up**
   - Review: [Pre-Publish Checklist](07_pre_publish_checklist.md)

---

## 🔐 Authentication Setup (Choose One)

### Option 1: SSH Setup (Recommended)

**Generate SSH key** (if you don't have one):

```bash
# Generate new SSH key
ssh-keygen -t ed25519 -C "your_email@example.com"
# or if ed25519 not supported:
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

# Press Enter to accept default location
# Enter passphrase (recommended for security)
```

**Add to SSH agent**:

```bash
# Start SSH agent
eval "$(ssh-agent -s)"

# Add key to agent
ssh-add ~/.ssh/id_ed25519
# or: ssh-add ~/.ssh/id_rsa
```

**Add to GitHub**:

1. Copy public key:
   ```bash
   # macOS
   pbcopy < ~/.ssh/id_ed25519.pub
   # Linux
   cat ~/.ssh/id_ed25519.pub | xclip -selection clipboard
   # Windows PowerShell
   Get-Content ~/.ssh/id_ed25519.pub | Set-Clipboard
   ```

2. Go to GitHub Settings → SSH and GPG keys
3. Click "New SSH key"
4. Paste the key
5. Click "Add SSH key"

**Test connection**:

```bash
ssh -T git@github.com
# Should show: "Hi username! You've successfully authenticated..."
```

### Option 2: HTTPS with Personal Access Token

**Create Personal Access Token**:

1. GitHub Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Click "Generate new token"
3. Name: "rekomendasi-wisata-push"
4. Expiration: 90 days (or your preference)
5. Scopes: Check `repo` (full control of private repositories)
6. Click "Generate token"
7. **Copy and save** the token (can't see it again)

**Configure Git to use token**:

```bash
# When prompted for password, use your token instead of password
git config --global credential.helper store
# or (recommended for security):
git config --global credential.helper osxkeychain  # macOS
git config --global credential.helper wincred       # Windows
git config --global credential.helper cache         # Linux
```

---

## 📱 Create GitHub Repository

### Step 1: Create Repository on GitHub

1. Go to https://github.com/new
2. **Repository name**: `rekomendasi-wisata`
3. **Description**: "AI-Powered Tourism Recommendation System using Hybrid ML"
4. **Visibility**: Public
5. **Initialize with**:
   - ❌ Don't add README (we have one)
   - ❌ Don't add .gitignore (we have one)
   - ❌ Don't add license (we'll add one)
6. Click **"Create repository"**

### Step 2: Copy Repository URL

After creation, you'll see:

```
https://github.com/yourusername/rekomendasi-wisata.git   (HTTPS)
git@github.com:yourusername/rekomendasi-wisata.git      (SSH)
```

Choose based on your authentication setup above.

---

## 🔄 Initialize Local Git Repository

### Step 1: Navigate to Project

```bash
cd /path/to/rekomendasi_wisata

# Verify you're in the right directory
pwd
ls -la README.md .gitignore
```

### Step 2: Initialize Git

```bash
# Initialize Git repository
git init

# Verify
git status
# Should show "On branch master"
```

### Step 3: Add Remote

```bash
# Add GitHub as remote
# Choose HTTPS or SSH based on your setup above

# HTTPS:
git remote add origin https://github.com/yourusername/rekomendasi-wisata.git

# or SSH:
git remote add origin git@github.com:yourusername/rekomendasi-wisata.git

# Verify remote added
git remote -v
# Should show:
# origin  git@github.com:yourusername/rekomendasi-wisata.git (fetch)
# origin  git@github.com:yourusername/rekomendasi-wisata.git (push)
```

---

## 📝 Stage and Commit Changes

### Step 1: Check Status

```bash
git status

# Should show all your project files as untracked
# Example output:
# On branch master
# No commits yet
# Untracked files:
#   (use "git add <file>..." to include in what will be committed)
#         README.md
#         .gitignore
#         .env.example
#         application/
#         ...
```

### Step 2: Configure Git User (First Time)

```bash
# Set your Git identity
git config user.name "Your Name"
git config user.email "your.email@example.com"

# Verify
git config --list | grep user
```

### Step 3: Add All Files

```bash
# Stage all files
git add .

# Or add specific files (optional)
git add README.md .gitignore docs/ application/ assets/ python/

# Verify staged files
git status
# Should show green "new file" entries
```

### Step 4: Create Initial Commit

```bash
# Commit with meaningful message
git commit -m "feat: Initial commit - Rekomendasi Wisata project

- Complete CodeIgniter web application with recommendation system
- Python Flask microservice for ML algorithms
- Hybrid recommendation engine (Collaborative + Content-Based)
- Database schema and documentation
- Deployment and API guides included"

# Verify commit
git log --oneline
# Should show your commit
```

**Alternative - Shorter commit**:

```bash
git commit -m "feat: Initial project setup with recommendation system"
```

---

## 🚀 Push to GitHub

### Step 1: Push to Remote

```bash
# Rename branch from 'master' to 'main' (if desired)
git branch -M main

# Push to GitHub
git push -u origin main
# or: git push -u origin master

# The -u flag sets the upstream (needed first time only)
# After this, you can just use: git push
```

**Troubleshooting push issues**:

```bash
# If authentication fails:
# - Verify SSH key is added to SSH agent
# - Or verify GitHub token is correct

# If branch conflict:
git pull --rebase origin main
git push origin main

# If rejected:
git push --force origin main
# (Use caution - only if you're sure)
```

### Step 2: Verify on GitHub

1. Go to https://github.com/yourusername/rekomendasi-wisata
2. Verify all files are there
3. Check that README.md displays correctly
4. Verify .gitignore is present

---

## 🏷️ Repository Configuration

### Step 1: Add Topics

1. Click **Settings** tab
2. Scroll to **Topics**
3. Add these tags:
   ```
   codeigniter
   php
   python
   machine-learning
   recommendation-system
   flask
   scikit-learn
   mysql
   tutorial
   full-stack
   ```

### Step 2: Add Description

Already done when creating repository, but can edit:

1. Click **Settings**
2. Edit **Description**: "AI-Powered Tourism Recommendation System"
3. Edit **Website** (if you have one)
4. Click **Save**

### Step 3: Protect Main Branch (Optional)

1. **Settings** → **Branches**
2. Click **Add rule** under Branch protection rules
3. Pattern name: `main`
4. Check:
   - ✅ Require pull request reviews before merging
   - ✅ Require status checks to pass
5. Click **Create**

---

## 📊 Add Additional Content

### Add License

```bash
# Create MIT License file
cat > LICENSE << 'EOF'
MIT License

Copyright (c) 2026 Your Name

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
EOF

# Add and commit
git add LICENSE
git commit -m "docs: Add MIT License"
git push origin main
```

### Add Contributing Guide

```bash
cat > CONTRIBUTING.md << 'EOF'
# Contributing to Rekomendasi Wisata

We welcome contributions! Here's how to help:

## Setup

1. Fork the repository
2. Clone your fork
3. Create a feature branch: `git checkout -b feature/your-feature`
4. Make changes
5. Commit: `git commit -m "feat: Your feature"`
6. Push: `git push origin feature/your-feature`
7. Create Pull Request

## Code Style

- Follow PSR-12 for PHP
- Follow PEP 8 for Python
- Write meaningful commit messages
- Add tests for new features
- Update documentation

## Questions?

Open an issue or discussion on GitHub.
EOF

git add CONTRIBUTING.md
git commit -m "docs: Add contributing guide"
git push origin main
```

---

## 🔄 Making Your First Update

After initial push, workflow for updates:

### Simple Update (One Change)

```bash
# Make changes to files
nano README.md

# Check what changed
git status

# Stage changes
git add README.md

# Commit
git commit -m "docs: Update README with better examples"

# Push
git push origin main
```

### Multiple Changes (Feature)

```bash
# Create feature branch
git checkout -b feature/add-recommendations-caching

# Make multiple changes
# ... edit files ...

# Stage all changes
git add .

# Commit
git commit -m "feat: Implement recommendation caching

- Add Redis support
- Improve performance by 50%
- Add cache invalidation strategy"

# Push to feature branch
git push -u origin feature/add-recommendations-caching

# Create Pull Request on GitHub
# 1. Visit repository on GitHub
# 2. Click "Compare & pull request"
# 3. Add description
# 4. Click "Create pull request"

# After review/approval, merge on GitHub
# Then update local main:
git checkout main
git pull origin main
git branch -d feature/add-recommendations-caching
```

---

## 🏷️ Create Release Tags

After first push, create version tags:

```bash
# Create annotated tag
git tag -a v1.0.0 -m "Release version 1.0.0 - Initial stable release"

# Push tag to GitHub
git push origin v1.0.0

# Or push all tags
git push origin --tags

# View tags on GitHub:
# Click "Code" → "Releases" tab
```

---

## 📊 Verify Everything

### Checklist After Push

- [ ] Repository visible on GitHub
- [ ] All files present
- [ ] README displays correctly
- [ ] .gitignore present
- [ ] .env.example present
- [ ] docs/ folder visible
- [ ] screenshots/ folder visible (if added)
- [ ] Topics assigned
- [ ] License included
- [ ] No __pycache__, .cache, or session files
- [ ] No .env file (only .env.example)
- [ ] Commit history looks good
- [ ] No sensitive data exposed

---

## 🎉 Success!

Your project is now on GitHub! Next steps:

1. ✅ Add repository URL to resume/portfolio
2. ✅ Share on social media
3. ✅ Pin repository to your GitHub profile
4. ✅ Start collecting stars ⭐
5. ✅ Monitor for forks and issues
6. ✅ Keep updating with improvements

---

## 🆘 Troubleshooting

### Permission Denied (SSH)

```bash
# Verify SSH agent is running
eval "$(ssh-agent -s)"

# Add key again
ssh-add ~/.ssh/id_ed25519

# Test connection
ssh -T git@github.com
```

### Authentication Failed (HTTPS)

```bash
# Use token instead of password
# Credentials stored: git config --list | grep credential

# Or clear cached credentials:
git credential-cache exit
git pull origin main
# Will prompt for credentials again
```

### File Too Large

```bash
# Git LFS (Large File Storage) setup
git lfs install
git lfs track "*.psd"
git add .gitattributes
git add large_file
```

### Forgot to Add .gitignore

```bash
# Add files that shouldn't be tracked
git rm -r --cached application/cache/
git add .gitignore
git commit -m "fix: Exclude cache files from tracking"
git push origin main
```

---

## 📚 Git Command Reference

```bash
# Viewing
git log                          # View commit history
git log --oneline               # Short commit history
git status                       # See current state
git diff                         # View changes
git remote -v                    # View remote URLs

# Staging
git add file.php                 # Add specific file
git add .                        # Add all changes
git reset file.php               # Unstage file
git reset                        # Unstage all

# Committing
git commit -m "message"          # Create commit
git commit --amend               # Fix last commit
git revert HEAD                  # Undo last commit

# Branches
git branch                       # List branches
git checkout -b feature/new      # Create new branch
git checkout main                # Switch branch
git merge feature/new            # Merge branch
git branch -d feature/new        # Delete branch

# Remote
git remote -v                    # List remotes
git fetch origin                 # Download updates
git pull origin main             # Fetch and merge
git push origin main             # Upload changes
git push origin --tags           # Upload tags

# Tags
git tag v1.0.0                   # Create lightweight tag
git tag -a v1.0.0 -m "message"   # Create annotated tag
git push origin v1.0.0           # Push specific tag
git push origin --tags           # Push all tags
```

---

## 🎓 Learn More

- [Official Git Tutorial](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Atlassian Git Tutorial](https://www.atlassian.com/git/tutorials)

