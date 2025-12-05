## This is a small, self-contained proof-of-concept to show how you approach building a feature from scratch.

There’s no “perfect” solution — we’re most interested in **your thinking, clarity, and pragmatism**.

## ✅ What to Build

### 1. Backend (Laravel) — Appointment Booking API

Build a minimal API to book an appointment.

**Requirements:**

- API Endpoint: Create an API endpoint to book an appointment.
- Request: The request must accept at least: a `service_id`, a `health_professional_id`, a `date`, and a customer `email`. The exact naming, formats, and DTO shape are up to you.
- Persistence: Persist the appointment somewhere.
- Confirmation: Trigger a confirmation notification to the provided address, but don’t actually send anything externally (e.g., log/array/fake).
- Documentation: Your `README.md` must document:
    - How to run the project (setup, migrations, etc.).
    - An example `curl` request to hit your endpoint.
    - A note on how to verify the "sent" email.

**Constraints:**

- No authentication
- Free to choose routing style, validation, data model, folder structure, patterns, etc.

## 🧠 What We Look For

We’ll review your:

- **Code quality & structure**
- **Clarity of logic and validation**
- **Use of Laravel best practices**
- **Commit hygiene & README clarity**
- **Pragmatic use of the stack — not overcomplicated**

---

## 💡 Optional Tips

- Use `.env` to separate config
- Use Laravel’s built-in tools for validation/mail/etc.
- Hardcode JSON if API for services/doctors is too much overhead
- Keep it simple but thoughtful — it doesn’t have to be “production-ready”

---

## 🔒 Constraints

- No Auth
- No external services (no live email, no third-party APIs)

## 🚀 Getting Started

1. **Set up the application:**

   ```bash
   cp .env.example .env
   composer install
   php artisan key:generate
   ./vendor/bin/sail up -d
   ```
2. **Run migrations:**

   ```bash
   ./vendor/bin/sail artisan migrate
   ./vendor/bin/sail artisan db:seed
   ```
3. **Check the docs:**

   Visit `http://localhost/docs`
