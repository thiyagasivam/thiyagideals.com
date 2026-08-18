# Affiliate Converter - Web Application

A mobile-responsive web application for converting affiliate links using the Ekaro Converter API.

## Features

- **Modern, Clean UI** - Professional design matching the provided mockup
- **Mobile Responsive** - Works seamlessly on desktop, tablet, and mobile devices
- **Link Conversion** - Convert affiliate links with simple link conversion
- **Real-time Feedback** - Loading indicators and error handling
- **Copy to Clipboard** - Easy result copying
- **Secure API Integration** - API key stored server-side

## Project Structure

```
v1/
├── index.html          # Main HTML structure and UI
├── styles.css          # Responsive styling
├── script.js           # Frontend JavaScript logic
├── converter.php       # Backend PHP API handler
└── README.md           # Documentation
```

## Requirements

- PHP 7.4 or higher
- cURL extension enabled in PHP
- Web server (Apache, Nginx, etc.)
- Modern web browser

## Setup Instructions

### 1. Prerequisites

Ensure your PHP environment has cURL enabled:
```bash
php -m | grep curl  # On Linux/Mac
php -m | find curl  # On Windows
```

### 2. File Placement

Place all project files in your web server's document root:
```
/xampp/htdocs/Aug/ek/v1/
├── index.html
├── styles.css
├── script.js
├── converter.php
└── README.md
```

### 3. API Configuration

The API key is configured in `converter.php` at the top of the file:

```php
$API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...';
```

**Important:** Keep this file secure and never expose your API key in frontend code.

### 4. Access the Application

Open your browser and navigate to:
```
http://localhost/Aug/ek/v1/
http://localhost/Aug/ek/v1/index.html
```

## Usage

1. **Paste Links** - Enter your affiliate links in the text area
2. **Click Convert** - Click the green "Convert" button
3. **Copy Results** - Click "Copy to Clipboard" to copy the converted links
4. **Close** - Click the "✕" button to close the results panel

## API Endpoints

### Frontend to Backend
- **Endpoint:** `converter.php`
- **Method:** POST
- **Content-Type:** application/json

**Request Body:**
```json
{
  "deal": "your affiliate links here",
  "convert_option": "convert_only"
}
```

**Response:**
```json
{
  "success": true,
  "result": "converted links here"
}
```

### Backend to Ekaro API
The application connects to:
```
https://ekaro-api.affiliaters.in/api/converter/public
```

Authentication uses Bearer token (your API key).

## Features Explained

### Mobile Responsive Design
- Optimized layouts for:
  - Desktop (1000px+)
  - Tablet (769px - 1000px)
  - Mobile (480px - 768px)
  - Small Mobile (<480px)



### Error Handling
- Network error detection
- API error handling
- User-friendly error messages
- Auto-dismissing error notifications

### Loading State
- Spinner animation during conversion
- Button disabled while processing
- Prevents duplicate submissions

### Result Management
- Results appear in a separate panel
- Smooth slide-in animation
- Copy button with feedback
- Close button to hide results

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Troubleshooting

### Issue: "Conversion service returned an error"
- Check your API key in `converter.php`
- Verify the API endpoint is accessible
- Check server PHP error logs

### Issue: cURL not working
- Ensure PHP cURL extension is installed
- Check with `php -m | grep curl`
- Enable cURL in php.ini and restart web server

### Issue: Button not responding
- Check browser console for JavaScript errors
- Verify `script.js` is loading correctly
- Clear browser cache and reload

### Issue: Mobile layout issues
- Ensure viewport meta tag is present in HTML
- Check browser zoom level
- Test with different device viewport sizes

## Security Considerations

1. **API Key Protection**
   - Never expose API key in frontend code
   - Keep `converter.php` on secure server
   - Use HTTPS in production

2. **Input Validation**
   - Backend validates all inputs
   - Whitelist allowed `convert_option` values

3. **CORS (if needed)**
   - Add CORS headers if frontend is on different domain
   - Example in `converter.php`:
   ```php
   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
   header('Access-Control-Allow-Headers: Content-Type');
   ```

## Performance Optimization

- Minified CSS and JavaScript (optional)
- Lazy loading for large responses
- Optimized mobile-first design
- Efficient DOM manipulation

## Production Deployment

1. **HTTPS Only** - Use SSL/TLS certificate
2. **Error Logging** - Configure proper error logging
3. **Rate Limiting** - Implement rate limiting on backend
4. **Environment Variables** - Store API key in environment variables
5. **Monitoring** - Set up application monitoring

## Developer Notes

### Frontend Stack
- Vanilla HTML5
- CSS3 with media queries
- Vanilla JavaScript (no dependencies)

### Backend Stack
- PHP 7.4+
- cURL library
- JSON processing

### No External Dependencies
- No frameworks required
- No CDN dependencies
- Self-contained application

## Customization

### Change Colors
Edit variables in `styles.css`:
```css
--primary-green: #1db854;  /* Convert button */
--toggle-red: #ff6b6b;     /* Toggle switches */
--primary-blue: #007bff;   /* Copy button */
```

### Modify Layout
Adjust padding and spacing in `styles.css`:
```css
header { padding: 40px 30px; }      /* Header spacing */
main { padding: 40px 30px; }        /* Main content spacing */
```

### Update API Endpoint
Edit in `converter.php`:
```php
$API_ENDPOINT = 'https://your-api-endpoint.com/path';
```

## Support & Issues

For issues with:
- **Frontend UI** - Check `index.html`, `styles.css`, `script.js`
- **Backend API** - Check `converter.php` and server logs
- **Network Issues** - Verify API endpoint and network connectivity

## License

This project is proprietary and confidential.

---

**Last Updated:** 2026-08-16
**Version:** 1.0.0
