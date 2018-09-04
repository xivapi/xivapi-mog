# XIVAPI Mog

This is Mog, the discord bot in the XIVAPI server. He is still a work-in-progress but there are not many bots built in PHP so this is quite fun!

Run as:
- `php bin/console RunCommand`

In discord do @mog and then follow the chain of messages. The bot is intended to be a natural language responder rather than remembering to do ".xxx" or w/e for commands.

## REST interaction

You can POST a JSON payload to: `/mog/message/post` with the structure:

```json
{
    "message": "Hello discord chat"
}
```

This will make the bot send that message to the chat.

### Note

This bot is hard coded to work in the XIVAPI server only, it is just a prototype at the moment and has no useful logic.