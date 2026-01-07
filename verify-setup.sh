#!/bin/bash

# 🚀 UPTIME MONITOR - QUICK START CHECKLIST
# This script helps verify all setup steps

echo "🚀 Uptime Monitor - Setup Verification Checklist"
echo "=================================================="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counters
PASSED=0
FAILED=0

# Function to check file exists
check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✓${NC} $2"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $2 - File not found: $1"
        ((FAILED++))
    fi
}

# Function to check command exists
check_command() {
    if command -v $1 &> /dev/null; then
        echo -e "${GREEN}✓${NC} $2 ($(which $1))"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $2 - Command not found"
        ((FAILED++))
    fi
}

# Function to check environment variable
check_env() {
    if [ -n "${!1}" ]; then
        echo -e "${GREEN}✓${NC} $2 is set"
        ((PASSED++))
    else
        echo -e "${YELLOW}⚠${NC} $2 not set (may be ok if using .env file)"
    fi
}

echo "📋 Environment Requirements"
echo "---"
check_command "php" "PHP installed"
check_command "composer" "Composer installed"
check_command "node" "Node.js installed"
check_command "npm" "npm installed"
check_command "mysql" "MySQL client installed"
check_command "redis-cli" "Redis CLI installed"
echo ""

echo "📁 Project Files"
echo "---"
check_file ".env" "Environment file (.env)"
check_file "composer.json" "Composer configuration"
check_file "package.json" "NPM configuration"
check_file "app/Console/Commands/DispatchWebsiteChecks.php" "Monitoring command"
check_file "app/Jobs/CheckWebsiteJob.php" "Monitoring job"
check_file "app/Mail/WebsiteStatusMail.php" "Email notification class"
check_file "routes/console.php" "Console routes (scheduler)"
check_file "routes/api.php" "API routes"
check_file "resources/js/App.vue" "Vue.js SPA"
echo ""

echo "🔧 Configuration Files"
echo "---"
check_file "config/mail.php" "Mail configuration"
check_file "config/database.php" "Database configuration"
check_file "config/queue.php" "Queue configuration"
check_file "database/migrations/2026_01_06_120000_add_indexes_for_scalability.php" "Database indexes"
echo ""

echo "📚 Documentation Files"
echo "---"
check_file "README.md" "Main README"
check_file "IMPLEMENTATION_GUIDE.md" "Implementation guide"
check_file "REQUIREMENTS_VERIFICATION.md" "Requirements checklist"
check_file "COMPLETION_SUMMARY.md" "Completion summary"
echo ""

echo "🔍 Verification Checks"
echo "---"

# Check if .env has key set
if grep -q "APP_KEY=" .env && [ "$(grep 'APP_KEY=' .env | cut -d= -f2)" != "" ] && [ "$(grep 'APP_KEY=' .env | cut -d= -f2)" != "base64:" ]; then
    echo -e "${GREEN}✓${NC} APP_KEY is configured"
    ((PASSED++))
else
    echo -e "${YELLOW}⚠${NC} APP_KEY may need to be set: php artisan key:generate"
fi

# Check if mail configuration is set correctly
if grep -q "do-not-reply@example.com" config/mail.php; then
    echo -e "${GREEN}✓${NC} Email sender is set to do-not-reply@example.com"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} Email sender not properly configured"
    ((FAILED++))
fi

# Check if scheduler is configured
if grep -q "monitor:dispatch-checks" routes/console.php; then
    echo -e "${GREEN}✓${NC} Scheduler is configured for monitor:dispatch-checks"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} Scheduler not configured"
    ((FAILED++))
fi

# Check if SES is default mailer
if grep -q "'default' => env('MAIL_MAILER', 'ses')" config/mail.php; then
    echo -e "${GREEN}✓${NC} SES is configured as default mail driver"
    ((PASSED++))
else
    echo -e "${YELLOW}⚠${NC} Default mail driver may need update for production"
fi

echo ""
echo "=================================================="
echo "📊 Summary: ${GREEN}$PASSED passed${NC}, ${RED}$FAILED failed${NC}"
echo "=================================================="
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✅ All checks passed! You're ready to go.${NC}"
    echo ""
    echo "Next steps:"
    echo "1. composer install && npm install"
    echo "2. php artisan migrate"
    echo "3. npm run build"
    echo ""
    echo "To run the application:"
    echo "- Terminal 1: php artisan serve"
    echo "- Terminal 2: php artisan queue:work"
    echo "- Terminal 3: php artisan schedule:work"
else
    echo -e "${RED}❌ Some checks failed. Please review the issues above.${NC}"
    exit 1
fi
