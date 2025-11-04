# Honeypot Web — Purposefully Vulnerable Web App (Educational)

Warning: This project intentionally contains security vulnerabilities for learning, testing, and blue-team/red-team training only.

Do not deploy this on a public-facing network or on any system that contains sensitive data. Read and follow the safety section carefully before running.

What is this project?
Honeypot Web is a purposefully vulnerable web application bundled into a reproducible Docker stack and a GitHub-hosted repository. It’s intended for classrooms, labs, CTF practice, and security research. The stack is configured so teams can practice detection, logging, WAF tuning, exploitation assessment, and incident response.

Core components:
PHP (Apache + mod_php) — the intentionally-vulnerable web application code (located in app/src/).
MySQL — simple backend used by the app (init SQL under app/src/init.sql).
Nginx + ModSecurity (OWASP CRS) — optional reverse-proxy Web Application Firewall (WAF) used to observe blocked/detected traffic.
Logstash → OpenSearch → OpenSearch Dashboards — centralized logging and searchable interface for logs, alerts, and investigations.
Log volume mounts — easy collection and external analysis.

Key purposes / use-cases:

Teach web-app vulnerabilities and secure coding practices.
Test WAF (ModSecurity) rules and tuning.
Collect and analyze attack data in OpenSearch/ELK-style pipeline.
Train blue teams to detect, triage, and respond to web attacks.
Provide a reproducible environment for team exercises.

# IMPORTANT SAFETY & LEGAL NOTICE:

This software is intentionally vulnerable. Misuse may be illegal and dangerous.

# Do NOT:
Expose this stack to the public Internet.
Run it on production, corporate, or otherwise sensitive networks.
Use real credentials, personal data, or access to third-party systems.

Safer deployment recommendations:

Run only inside an isolated lab (air-gapped VM, isolated VLAN, or private cloud VPC).
Use strict firewall rules: allow only necessary inbound access from trusted lab machines.
Limit egress (no unrestricted Internet access for honeypot containers unless required).
Use NAT or jump hosts to control inbound/outbound flows.
Use fake/test data only. Rotate all secrets and passwords between lab runs.
Log everything and ship logs to a dedicated, immutable store (OpenSearch with RBAC).
Get written permission for any testing that involves third-party systems, networks, or people.

!!!YOU ARE RESPONSIBLE FOR HOW YOU USE THIS SOFTWARE!!!

Reproducibility & Distribution:

You can reproduce and run the full stack either from the GitHub repo or by pulling the prebuilt container image.

From GitHub (recommended for full-stack/CI):

Repository: https://github.com/Cyborkin/Project-MECC:
-Clone and run (example):
- git clone https://github.com/Cyborkin/Project-MECC.git
- cd Project-MECC
- cp .env.example .env        #edit .env with safe lab values (do NOT add real secrets)
- docker compose up --build   #builds web image and launches full stack: DB, web, WAF, logstash, opensearch, dashboards

From container registry (quick run — image only):

Prebuilt web image (published to GHCR / repo packages):

- ghcr.io/cyborkin/project-mecc:latest #or (if published to Docker Hub)
- docker.io/cyborkin/honeypot-web:2025-10-27

Run the single web container:

- mkdir -p honeypot_logs
- docker pull ghcr.io/cyborkin/project-mecc:latest
- docker run --rm -p 8080:80 -v "$(pwd)/honeypot_logs:/var/log/apache2" ghcr.io/cyborkin/project-mecc:latest
- #Visit: http://localhost:8080
- If you need the whole pipeline (WAF, DB, Logstash/OpenSearch), use the docker-compose.yml in the repo and run docker compose up --build.

Ports used (default):

- 80 — internal container Apache (mapped by docker run)
- 8080 — WAF public port (default host mapping 8080:8080 in compose)
- 9200 — OpenSearch (host:container mapping 9200:9200)
- 5601 — OpenSearch Dashboards (host:container mapping 5601:5601)

You can override host ports with HOST_PORT=8081 docker compose up or docker run -p 8081:80 ....
Environment variables (example .env.example)
Store secrets locally in .env (never commit .env to git). Example values in .env.example:

- MYSQL_ROOT_PASSWORD=rootpassword
- MYSQL_DATABASE=honeypot
- MYSQL_USER=honeypot
- MYSQL_PASSWORD=honeypotpass
- OPENSEARCH_INITIAL_ADMIN_PASSWORD=change_me
- HOST_PORT=8080

Directory layout (important files):

- /projects/honeypot-web
- ├─ app/
- │  ├─ src/                # vulnerable PHP app source (index.php, includes, SQL)
- │  └─ logs/               # bind-mounted Apache logs
- ├─ apache/
- │  └─ servername.conf
- ├─ Dockerfile             # single root Dockerfile for web image
- ├─ docker-compose.yml     # full-stack orchestration
- ├─ .github/workflows/ghcr.yml  # CI: build & push to GHCR
- ├─ README.md
- └─ .env.example

How logging & monitoring is wired:

Apache writes access + error logs to /var/log/apache2 inside the container.
Nginx WAF writes nginx + ModSecurity logs to /var/log/nginx and ModSecurity audit logs to /var/log/modsecurity.
Logstash reads logs from the host-mounted log directories and forwards them to OpenSearch.
OpenSearch Dashboards provides a web UI to search, visualize, and analyze log events and attack data.
This setup is intentionally observable so students can see exploit traffic in the logs and dashboards.

Troubleshooting tips:

500 Internal Server Error through WAF:
- Check Apache error log: docker compose exec web tail -n 200 /var/log/apache2/error.log
- Check WAF logs: tail -n 200 ./waf/logs/error.log and ./waf/modsec/*

DB connection failures:
- Ensure MySQL service db is up and the schema applied.
- The app must connect to service name db (Compose network), not localhost.

No data in OpenSearch:
- Verify Logstash pipeline is running and input paths match mounted logs.
- Confirm OpenSearch is healthy: curl -s http://localhost:9200/_cluster/health?pretty

Image build fails:
- Ensure the root Dockerfile is used (delete app/Dockerfile if present).
- Rebuild with no cache: docker compose build --no-cache web.

Development & contribution:

This project is free and open-source — contributions welcome. 
Suggested contribution workflow:
- Fork the repo → create a feature branch → open a pull request.
- Run the test/dev stack locally (docker compose up --build).
- If adding new vulns, clearly document them and add remediation notes in docs (we want learning value).
- Keep secrets out of commits (.env only local; commit .env.example).

Suggested files to include in PRs:
- CONTRIBUTING.md — contribution guidelines
- CHANGELOG.md — release notes for versions
- db/migrations/ — incremental SQL migration files (avoid replacing a single init.sql)
- CI / Auto-publish to GHCR

A GitHub Actions workflow exists at .github/workflows/ghcr.yml that builds the root Dockerfile and pushes image tags to GHCR under ghcr.io/cyborkin/project-mecc. The workflow tags:
- ghcr.io/cyborkin/project-mecc:latest
- ghcr.io/cyborkin/project-mecc:<commit-sha>
- You can trigger it by pushing to main or running it manually from the Actions tab.

Security best-practices & mitigations (recommended for labs):

- Run honeypot containers in an isolated VM or VLAN separated from your corporate / home network.
- Configure host firewall rules (iptables, UFW) to limit inbound connections to trusted IP ranges.
- Disable container egress if not needed, or restrict it via network policies.
- Use ephemeral lab VMs and obliterate them (destroy VM + volumes) after exercises to remove artifacts.
- Do not connect logs or alerting sinks that include production credentials.
- Run OpenSearch/Dashboards behind authentication and TLS if accessible beyond local host.

License:

This project is provided under the MIT License (see LICENSE in repo). Use and modification are permitted. If you publish derived work, please attribute the original project where reasonable.

Acknowledgements & maintainer

Maintainer: @Cyborkin

Repo: https://github.com/Cyborkin/Project-MECC

If you use this in a course or lab, please credit the maintainer and include a note in your syllabus or lab instructions about the intentional vulnerabilities.

Quick start recap:

Full stack (recommended for team labs):
- git clone https://github.com/Cyborkin/Project-MECC.git
- cd Project-MECC
- cp .env.example .env
- docker compose up --build
- Open:
- WAF + app: http://localhost:8080
- OpenSearch: http://localhost:9200
- Dashboards: http://localhost:5601
- Single image (fast local test):
- mkdir -p honeypot_logs
- docker pull ghcr.io/cyborkin/project-mecc:latest
- docker run --rm -p 8080:80 -v "$(pwd)/honeypot_logs:/var/log/apache2" ghcr.io/cyborkin/project-mecc:latest
