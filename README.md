# Honeypot Web (Apache + PHP)

A reproducible, intentionally vulnerable web honeypot for research and blue-team training. **Run only in isolated/lab networks you control.** Do not expose where prohibited by policy or law.

## Quick start (no build)
```bash
docker pull cyborkin/honeypot-web:2025-10-27
docker run --rm -p 8080:80 -v $(pwd)/logs/apache2:/var/log/apache2 cyborkin/honeypot-web:2025-10-27
# open http://localhost:8080

