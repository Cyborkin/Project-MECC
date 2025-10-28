CONTRIBUTING.md
Contributing to Project-MECC / Honeypot Web
Thank you for your interest in contributing — we appreciate improvements, bug reports, and thoughtful discussion. This document explains how to contribute code, documentation, tests, and configuration to the project in a way that keeps the repo stable, auditable, and secure.
Table of contents
Code of conduct
Getting started / development setup
Branching & naming conventions
Commit message style
Pull request process
Continuous integration (CI) expectations
Testing & local verification
Security, responsible disclosure & secrets
Documentation & examples
Small contributions & triage
License & attribution
Code of conduct
This project follows the Code of Conduct in CODE_OF_CONDUCT.md. Please read it before participating.
Getting started / development setup
These steps get a development environment ready so you can run and test changes locally.
Clone the repo:
git clone https://github.com/Cyborkin/Project-MECC.git
cd Project-MECC
Copy the example env and edit values (don’t commit secrets):
cp .env.example .env
# edit .env for your local lab values
Build and run the full stack (recommended for development):
docker compose up --build
Or build the web image only:
docker compose build --no-cache web
docker compose up web
Verify services:
App (via WAF): http://localhost:8080
OpenSearch: http://localhost:9200
Dashboards: http://localhost:5601
Branching & naming conventions
Keep branches focused and short-lived.
Base branch: main (protected)
Create feature/fix branches from main:
Feature: feature/<short-descriptor> e.g. feature/add-health-check
Bugfix: bugfix/<short-descriptor> e.g. bugfix/fix-php-ext
Hotfix/release: hotfix/<version-or-issue> e.g. hotfix/0.1.1
Do not commit directly to main. Open a pull request for all changes.
Commit message style
Use concise, clear messages to make history readable.
Recommended format:
<type>(<scope>): <short summary>

<detailed description — optional>

Resolves: #<issue-number>  # (if applicable)
type: feat, fix, docs, chore, ci, test, refactor, perf, build
scope (optional) could be docker, web, waf, logstash, opensearch, etc.
Example:
feat(docker): add php-mbstring and php-mysql packages

Add php extensions needed by the honeypot app. This prevents 500 errors
when connecting via mysqli.
Pull request process
Fork (if you don’t have push access) and create a branch.
Make atomic commits with clear messages.
Ensure tests and linters pass locally.
Push your branch and open a PR to main:
Title: short descriptive phrase
Description: what you changed, why, how to test, any migration steps
Link related issue(s) with Resolves #NN or Fixes #NN where appropriate
PR checklist (add these items as a checklist in the PR description):
 I have read the Code of Conduct
 My changes build successfully (docker compose build --no-cache web)
 No secrets are committed
 I updated docs (README.md, LAB-WORKSHEET.md, or relevant docs) if needed
 For schema changes, migration scripts / SQL are included under app/db/migrations/
Review:
At least one approving review required before merge (protect main)
CI must pass (see next section)
Merge:
Prefer “Squash and merge” for small feature branches, unless preserving history is important.
Add a release tag if the change warrants a new image version (e.g., v1.0.0).
Continuous integration (CI) expectations
We use GitHub Actions to build images and run checks.
Workflow(s) live at .github/workflows/
All PRs must trigger CI:
Build container image (ensure Dockerfile builds cleanly)
Lint or basic static checks (if added)
Optional tests (unit / integration) to be added over time
A successful CI run is required before merging.
For changes that affect image content, ensure the workflow tags and push behavior remain correct for GHCR.
Testing & local verification
Unit tests: add under tests/ (if project expands with testable modules)
Integration tests (manual):
docker compose up --build
Smoke test endpoints:
curl -I http://localhost:8080/
docker compose exec web curl -I http://127.0.0.1/
curl -s http://localhost:9200/_cluster/health?pretty
For DB schema changes:
Add migration SQL files under app/db/migrations/
Add a short README on how to apply migrations.
Security, responsible disclosure & secrets
Do not commit secrets (.env files, keys, tokens). Use .env.example only.
If you discover a security vulnerability:
Do NOT publish details publicly.
Contact the maintainers privately: chase.kozy93@gmail.com (replace with the maintainer contact) and provide a short, reproducible description.
Give maintainers reasonable time to respond and remediate.
For critical vulnerabilities, include steps to reproduce in a private message and suggested mitigations.
Documentation & examples
Keep README.md up to date for run instructions.
Add change-specific docs under docs/ when adding new features (WAF tuning examples, Logstash pipeline notes, etc.).
Add quick-start snippets to the top of README for common tasks.
Small contributions & triage
Small fixes (typos, formatting) can be opened directly as PRs.
If you open an issue, include:
Brief description
Steps to reproduce
Expected vs actual result
Relevant logs or error messages (redact secrets)
License & attribution
This repository is licensed under the MIT License. Include a LICENSE file at the repo root. By contributing, you agree your contributions are licensed under the project license.
Thanks again — your contributions make the project better and more useful for everyone. If anything in this document is unclear or you want a different flow for your team, open an issue or message the maintainer.
