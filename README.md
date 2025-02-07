## Telegram Messaging Web Service

This is a web service that enables communication between a user of the service via a Telegram bot. The user can send messages to the bot, which are then saved by the web service. The user of the web service can respond to the messages.

## Requirements

- **Laravel** framework
- **Docker** and **Docker Compose** for running the service
- **Telegram Bot API** for integration with the Telegram bot
- **Composer** for dependency management

## Features

- Messages sent to the Telegram bot are forwarded and saved by the web service.
- The web service user can view and respond to these saved messages.
- The response will be sent back to the user via the Telegram bot.

## Installation

### 1. Clone the repository
Clone this repository to your local machine:

### 2. Set up environment variables

After cloning the repository, you need to configure the environment variables for your application.

**Edit the .env file:**:
   Open the .env file and set up the following:
- TELEGRAM_BOT_TOKEN=your-telegram-bot-token 


### 3. Setting up the Telegram bot webhook
```bash
curl -X POST "https://api.telegram.org/bot$TELEGRAM_BOT_TOKEN/setWebhook" -d "url=$APP_URL/telegram/webhook"
