# SPR - Simple PHP Redirect

A lightweight, GDPR-compliant PHP application that logs and redirects incoming requests based on configurable rules.

## Features

- 🔀 **Configurable Redirects**: Redirect all traffic to a specified domain
- 📝 **GDPR-Compliant Logging**: Logs requests without storing personal data
- ⚡ **Zero Dependencies**: Pure PHP implementation
- 🛠️ **Simple Configuration**: JSON-based configuration file
- 🔒 **Secure**: Prevents direct access to configuration and log files

## Requirements

- PHP 7.0 or higher
- Apache web server with mod_rewrite enabled
- Write permissions for the logs directory

## Installation

1. Clone or download this repository
2. Upload all files to your web server
3. Edit `config.json` to set your redirect destination
4. Ensure the web server can write to the directory (for creating logs)

## Configuration

Edit the `config.json` file to customize the redirect behavior:

```json
{
    "redirectDomain": "https://example.com",
    "dontIncludePaths": false,
    "permanentRedirect": false
}
```

### Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `redirectDomain` | string | - | The target domain for all redirects |
| `dontIncludePaths` | boolean | false | If true, strips the path from the original URL when redirecting |
| `permanentRedirect` | boolean | false | If true, uses 301 (permanent) redirect; otherwise uses 302 (temporary) |

## Usage Examples

### Basic Redirect
- Request: `http://yourdomain.com/page`
- Redirects to: `https://example.com/page`

### Without Path (dontIncludePaths: true)
- Request: `http://yourdomain.com/page`
- Redirects to: `https://example.com`

## Logging

The application creates daily log files in the `logs/` directory with the format `YYYYMMDD-log.json`.

### Log Entry Structure

```json
{
    "time": "2025-08-12T10:30:00+00:00",
    "domain": "yourdomain.com",
    "path": "/requested/path",
    "browserInformation": {
        "type": "Chrome",
        "is_mobile": false
    }
}
```

### GDPR Compliance

The logger only stores:
- Timestamp
- Requested domain and path
- Generic browser type (Chrome, Firefox, Safari, etc.)
- Mobile device indicator (true/false)

**No personal data is logged**, including:
- ❌ IP addresses
- ❌ Detailed user agent strings
- ❌ Cookies or session data
- ❌ Referrer information

## File Structure

```
/
├── .htaccess          # Apache configuration
├── index.php          # Main application logic
├── config.json        # Configuration file
├── README.md          # This file
└── logs/              # Log files directory (auto-created)
    └── YYYYMMDD-log.json
```

## Security

- The `.htaccess` file prevents direct access to JSON files
- All requests are routed through `index.php`
- No user input is directly executed or included

## Troubleshooting

### Redirects not working
- Ensure mod_rewrite is enabled on your Apache server
- Check that `.htaccess` files are allowed (AllowOverride All)

### Logs not being created
- Verify the web server has write permissions for the application directory
- Check PHP error logs for permission issues

### 500 Internal Server Error
- Ensure `config.json` exists and contains valid JSON
- Check PHP error logs for syntax errors

## License

This project is open source and available under the [MIT License](LICENSE).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues, questions, or contributions, please open an issue on GitHub.
