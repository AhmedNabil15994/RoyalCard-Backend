# WAIntegration
simple laravel package to connect your whatsapp and send messages.


# Installation
```
composer require tocaan/gowasl-package
```

After updating composer, add the ServiceProvider to the providers array in config/app.php. <br />
 
```
WAIntegration\WAServiceProvider::class, 
```

Optionally you can use the Facade for shorter code. Add this to your facades: <br />

```
'Instance' => WAIntegration\Facades\InstanceFacade::class, 
'Message' => WAIntegration\Facades\MessageFacade::class, 
```

 more is coming soon. <br />

 Finally you can publish the config file: <br />
```
 php artisan vendor:publish --provider="WAIntegration\WAServiceProvider"  
```

# Configuration
 The main change to this config file (config/wa_integration.php) will be filled with your channel credentials. <br />

 For example, when loaded with composer, the line should look like: <br />
```
 'id'                    => env('WA_CHANNEL_ID','YOUR_CHANNEL_ID_HERE'),
 'token'                 => env('WA_CHANNEL_TOKEN','YOUR_CHANNEL_TOKEN_HERE'),
 'identifier'            => env('WA_CHANNEL_IDENTIFIER','YOUR_CHANNEL_OWNER_IDENTIFIER_HERE'), 
```

# Usage

 You can create a new (Message or Instance) instance and begin sending messages or fetching qr & account activity status. <br />

 # Use the facade:
 
 ## - Instance Facade

   
```
   Instace::qr()
```
   To fetch current qr  <br />
```
   Instance::status() 
```
   To Check If account status is active or disconnected <br />
```
   Instance::disconnect() 
```
   Disconnect Channel Connection <br />
```
   Instance::clearInstance() 
```
   Delete Channel, becareful when trying to use it <br />
```
   Instance::clearInstanceData() 
```
   Clear all files associated with channel <br />

 ## - Message Facade
 - Send Text Message Via Whatsapp <br />
```
   Message::send([
      'phone' => '965xxxxxxxx',
      'body'  => 'Your Message Body Here'
   ]) 
```

- Send Multi-Media Message Via Whatsapp <br />
- Image
```
   Message::sendImage([
      'phone' => '965xxxxxxxx',
      'url'  => 'url of your image',
      'caption' => 'image caption (optional)'
   ]) 
```
- Video
```
   Message::sendVideo([
      'phone' => '965xxxxxxxx',
      'url'  => 'url of your video',
      'caption' => 'image caption (optional)'
   ]) 
```
- Audio
```
   Message::sendAudio([
      'phone' => '965xxxxxxxx',
      'url'  => 'url of your audio file',
   ]) 
```
- Document
```
   Message::sendFile([
      'phone' => '965xxxxxxxx',
      'url'  => 'url of your document file',
   ]) 
```
- Link
```
   Message::sendLink([
      'phone' => '965xxxxxxxx',
      'url'  => 'HTTPS URL',
      'title' => 'URL Title',
      'body' => 'URL Description',
   ]) 
```
- Sticker
```
   Message::sendSticker([
      'phone' => '965xxxxxxxx',
      'url'  => 'url of your Sticker',
   ]) 
```
- Gif
```
   Message::sendGif([
      'phone' => '965xxxxxxxx',
      'url'  => 'url of your Gif',
      'caption' => 'Gif caption (optional)'
   ]) 
```
- Location
```
   Message::sendLocation([
      'phone' => '965xxxxxxxx',
      'lat'  => 'location latitude',
      'lng' => 'location longitude'
   ]) 
```
- Contact
```
   Message::sendContact([
      'phone' => '965xxxxxxxx',
      'name'  => 'Contact Name',
      'contact' => 'Contact Whatsapp Number',
      'organization' => 'Contact Organization (optional)',
   ]) 
```
- Mention
```
   Message::sendMention([
      'phone' => '965xxxxxxxx',
      'mention' => 'Mention Whatsapp Number',
   ]) 
```
 
 Note: Your Connection status must be connected it means that you had already scanned QR.
