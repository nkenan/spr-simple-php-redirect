===============================================================================
SPR - Simple PHP Redirect
Developer Documentation
===============================================================================

>>> ATTENTION: ACTIVE REDIRECT SYSTEM <<<
This directory contains an ACTIVE redirect system. All incoming requests are
being redirected to another domain. If you're debugging connection issues,
this might be the cause.

WHAT IS SPR?
------------
SPR (Simple PHP Redirect) is a lightweight PHP application that:
- Redirects ALL incoming traffic to another domain
- Logs requests in a GDPR-compliant manner
- Was likely installed for domain migration or traffic forwarding

HOW TO TEMPORARILY DISABLE SPR
------------------------------
Option 1 - Rename the main file:
    mv spr-simple-php-redirect.php spr-simple-php-redirect.php.disabled

Option 2 - Comment out .htaccess rules:
    Add # before each line in the SPR section of .htaccess

Option 3 - Rename .htaccess:
    mv .htaccess .htaccess.spr-backup

HOW TO COMPLETELY REMOVE SPR
----------------------------
1. Delete or backup these files:
   - spr-simple-php-redirect.php
   - spr-simple-php-redirect-config.json
   - spr-simple-php-redirect-README.txt (this file)
   
2. Remove SPR rules from .htaccess:
   - Look for the section "# Redirect all requests to spr-simple-php-redirect.php"
   - Delete all SPR-related RewriteRules and conditions
   
3. Optionally remove logs:
   - rm -rf spr-logs/

4. Test your website to ensure it works without SPR

IDENTIFYING SPR FILES
--------------------
All SPR files use the prefix "spr-" for easy identification:
- spr-simple-php-redirect.php (main script)
- spr-simple-php-redirect-config.json (configuration)
- spr-simple-php-redirect-README.txt (documentation)
- spr-logs/ (log directory)
- YYYYMMDD-spr-log.json (daily log files)

CHECKING CURRENT CONFIGURATION
------------------------------
View where traffic is being redirected:
    cat spr-simple-php-redirect-config.json

Example output:
{
    "redirectDomain": "https://example.com",  <- All traffic goes here
    "dontIncludePaths": false,
    "permanentRedirect": false
}

===============================================================================

OVERVIEW
--------
SPR (Simple PHP Redirect) is a lightweight PHP application designed to redirect
incoming traffic while maintaining GDPR-compliant logs. It can be integrated
into existing websites without interfering with other applications.

INTEGRATION GUIDE
-----------------
1. Copy all SPR files to your web root or subdirectory
2. The SPR-prefixed naming convention prevents conflicts with existing files
3. Modify .htaccess rules as needed for your specific setup
4. Configure spr-simple-php-redirect-config.json with your redirect target

TECHNICAL DETAILS
-----------------
- Main Script: spr-simple-php-redirect.php
- Config File: spr-simple-php-redirect-config.json
- Log Directory: spr-logs/
- Log Format: YYYYMMDD-spr-log.json

CONFIGURATION OPTIONS
---------------------
{
    "redirectDomain": "https://example.com",  // Target domain for redirects
    "dontIncludePaths": false,               // Strip paths from URLs if true
    "permanentRedirect": false               // Use 301 instead of 302 if true
}

HTACCESS NOTES
--------------
The included .htaccess file:
- Routes all non-file/non-directory requests to SPR
- Blocks direct access to SPR configuration and log files
- May need adjustment if you have existing rewrite rules

For subdirectory installation, adjust the RewriteBase:
    RewriteBase /your-subdirectory/

LOGGING BEHAVIOR
----------------
- Logs are stored in spr-logs/ directory (auto-created)
- One log file per day: YYYYMMDD-spr-log.json
- Each entry contains: timestamp, domain, path, browser info
- NO personal data logged (no IPs, cookies, or user agents)

GDPR COMPLIANCE
---------------
SPR only logs:
- Request timestamp
- Requested domain and path
- Generic browser type (Chrome, Firefox, etc.)
- Mobile device indicator (true/false)

TROUBLESHOOTING
---------------
1. 500 Error: Check JSON syntax in config file
2. No redirects: Verify mod_rewrite is enabled
3. No logs: Check write permissions on directory
4. Conflicts: Review existing .htaccess rules

CUSTOMIZATION
-------------
To modify redirect behavior:
- Edit the main PHP file's redirect logic
- Add custom headers before the Location header
- Implement conditional redirects based on paths

To change log format:
- Modify the $logEntry array in the PHP file
- Ensure you maintain GDPR compliance

SECURITY CONSIDERATIONS
-----------------------
- Never log personal data
- Keep config file outside web root if possible
- Regularly rotate/archive old log files
- Monitor log file sizes to prevent disk issues

VERSION HISTORY
---------------
- 1.0.0: Initial release with basic redirect and logging

SUPPORT
-------
For issues or questions, refer to the main README.md or open an issue
on the project's GitHub repository.

===============================================================================
