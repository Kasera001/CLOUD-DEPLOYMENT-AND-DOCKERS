<div align="center">

#  Cloud Deployment & Dockers

**A containerised PHP + MySQL web app, built with Docker and deployed to the cloud.**

![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Docker Compose](https://img.shields.io/badge/Docker_Compose-2496ED?logo=docker&logoColor=white)
![Cloud](https://img.shields.io/badge/Deployed_to-CLOUD_PROVIDER-orange)

</div>

##  About
This repository holds the Dockerfiles and application code I use to build applications and containers in Docker and then deploy them to the cloud. The app is a user-account system with registration, login, password reset by email, a dashboard and search.

##  Features
- User registration and login
- Forgot password and reset password flow, with email sent through `msmtp`
- Dashboard for logged-in users
- Search page
- Database created automatically from `Init.sql`
- One-command startup with Docker Compose



##  Project Structure

| File | Purpose |
|---|---|
| `dockerfile` | Builds the PHP web app image |
| `docker-compose.yml` | Runs the web app and database together |
| `Init.sql` | Creates the database tables on first start |
| `db.php` | Database connection |
| `index.php` | Login page |
| `register.php` | New user sign-up |
| `dashboard.php` | Page shown after login |
| `search.php` | Search feature |
| `forgot-password.php` / `reset-password.php` | Password recovery |
| `logout.php` | Ends the session |
| `msmtprc` | Mail configuration template |
| `style.css` | Styling |

##  Getting Started

### Prerequisites
- [Docker](https://docs.docker.com/get-docker/) and Docker Compose installed

### Run locally
```bash
git clone https://github.com/Kasera001/CLOUD-DEPLOYMENT-AND-DOCKERS.git
cd CLOUD-DEPLOYMENT-AND-DOCKERS
docker compose up --build
```

Then open **http://localhost:PORT** in your browser (use the port mapped in `docker-compose.yml`).

### Stop everything
```bash
docker compose down        # stop containers
docker compose down -v     # also delete the database volume
```

##  Configuration
Secrets are **not** stored in this repo. Create a `.env` file (already ignored by Git) with values like:

```env
DB_HOST=db
DB_NAME=your_database
DB_USER=your_user
DB_PASSWORD=your_password
```



##  What I Learned
- Writing Dockerfiles and multi-container setups with Docker Compose
- Connecting a web container to a database container
- Managing configuration and secrets outside the code
- Deploying containers to a cloud environment



##  Author
**Stella Genevive Awuor** · [GitHub](https://github.com/Kasera001)
