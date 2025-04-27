# OAUTH-LAB

A practical Laravel-based OAuth2 lab designed for developers and security researchers to understand and test various OAuth2 scenarios, including misconfigurations and common vulnerabilities like CSRF and etc...

## Purpose

This lab simulates real-world OAuth2 flows and is meant for:

- Understanding Authorization Code Flow
- Practicing security assessments on OAuth implementations
- Demonstrating OAuth misconfigurations (e.g., `missing state parameter`)
- Simulating account linking and third-party login systems

## Features

- Login using email/password
- Login using Google OAuth2
- Link an existing account with a Google account
- Refresh tokens automatically using Laravel Jobs
- Cron-based background token refresh
- Demonstrates:
  - Missing `state` parameter
  - CSRF in account linking

## Tech Stack

- Laravel 12
- Socialite (for OAuth)
- MySQL
- PHP 8+
- Google OAuth2

## Setup Instructions

**Clone the repo LAB:**

```bash
git clone https://github.com/0xx01/OAuth-LAB.git
cd OAuth-LAB
cp .env.example .env
```
** Install dependencies: **

```bash
composer install
npm install && npm run dev
```
**Configure .env: env**
1. Go to Google Cloud Console.
2. Create a new OAuth2 credential
3. Add Authorized redirect URLS and copy client_id, CLIENT_SECRET to addd in .env file.
```GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/callback
GOOGLE_Connect_REDIRECT_URI=https://yourdomain.com/account/connect/google
```
**Run migrations:**

```bash
php artisan migrate
```
**Run the app:**
```bash
php artisan key:generate
php artisan serve
```
**Scheduled Token Refresh**
```pgsql
* * * * * php /path_the_lab/artisan schedule:run >> /dev/null 2>&1
```

## Attack Scenarios

| #  | Scenario Title                   | Description                                                                | Risk / Impact                          |
|----|-----------------------------------|----------------------------------------------------------------------------|----------------------------------------|
| 1  | Missing State Parameter           | Absence of `state` in OAuth flow allows CSRF and code injection.            | CSRF / Code Hijack                     |
| 2  | Pre-Account Takeover               | Attacker registers email before victim uses OAuth.                         | Full Account Hijack                    |
| 3  | No Refresh Token Rotation          | Refresh token reused multiple times without rotation.                      | Long-Term Token Theft                  |
| 4  | Missing Email Verification in OAuth| OAuth login bypasses manual email verification.                            | Access to Unverified Accounts          |


## Contributions
Feel free to open issues, submit pull requests, or suggest new OAuth attack scenarios!
