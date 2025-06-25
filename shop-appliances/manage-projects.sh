#!/bin/bash

# Script quản lý nhiều projects trên server

PROJECTS_DIR="/opt/projects"
BACKUPS_DIR="/opt/backups"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

show_menu() {
    echo -e "${BLUE}🚀 Multi-Project Server Management${NC}"
    echo "=================================="
    echo "1. List all projects"
    echo "2. Start project"
    echo "3. Stop project"
    echo "4. Restart project"
    echo "5. View project logs"
    echo "6. Backup project"
    echo "7. Update project"
    echo "8. Create new project"
    echo "9. Server status"
    echo "0. Exit"
    echo ""
}

list_projects() {
    echo -e "${BLUE}📁 Available Projects:${NC}"
    if [ -d "$PROJECTS_DIR" ]; then
        ls -la $PROJECTS_DIR/ | grep ^d | awk '{print "   - " $9}' | grep -v "^   - \.$" | grep -v "^   - \.\.$"
    else
        echo "   No projects found"
    fi
    echo ""
}

start_project() {
    echo -e "${YELLOW}Project name:${NC}"
    read project_name
    
    if [ -d "$PROJECTS_DIR/$project_name" ]; then
        echo -e "${BLUE}Starting $project_name...${NC}"
        cd $PROJECTS_DIR/$project_name
        docker-compose up -d
        echo -e "${GREEN}✅ $project_name started${NC}"
    else
        echo -e "${RED}❌ Project $project_name not found${NC}"
    fi
}

stop_project() {
    echo -e "${YELLOW}Project name:${NC}"
    read project_name
    
    if [ -d "$PROJECTS_DIR/$project_name" ]; then
        echo -e "${BLUE}Stopping $project_name...${NC}"
        cd $PROJECTS_DIR/$project_name
        docker-compose down
        echo -e "${GREEN}✅ $project_name stopped${NC}"
    else
        echo -e "${RED}❌ Project $project_name not found${NC}"
    fi
}

restart_project() {
    echo -e "${YELLOW}Project name:${NC}"
    read project_name
    
    if [ -d "$PROJECTS_DIR/$project_name" ]; then
        echo -e "${BLUE}Restarting $project_name...${NC}"
        cd $PROJECTS_DIR/$project_name
        docker-compose restart
        echo -e "${GREEN}✅ $project_name restarted${NC}"
    else
        echo -e "${RED}❌ Project $project_name not found${NC}"
    fi
}

view_logs() {
    echo -e "${YELLOW}Project name:${NC}"
    read project_name
    
    if [ -d "$PROJECTS_DIR/$project_name" ]; then
        echo -e "${BLUE}Viewing logs for $project_name...${NC}"
        cd $PROJECTS_DIR/$project_name
        docker-compose logs -f --tail=50
    else
        echo -e "${RED}❌ Project $project_name not found${NC}"
    fi
}

backup_project() {
    echo -e "${YELLOW}Project name:${NC}"
    read project_name
    
    if [ -d "$PROJECTS_DIR/$project_name" ]; then
        DATE=$(date +%Y%m%d_%H%M%S)
        BACKUP_FILE="$BACKUPS_DIR/${project_name}_backup_$DATE.tar.gz"
        
        echo -e "${BLUE}Creating backup for $project_name...${NC}"
        mkdir -p $BACKUPS_DIR
        
        cd $PROJECTS_DIR
        tar -czf $BACKUP_FILE $project_name --exclude="$project_name/node_modules" --exclude="$project_name/vendor"
        
        echo -e "${GREEN}✅ Backup created: $BACKUP_FILE${NC}"
    else
        echo -e "${RED}❌ Project $project_name not found${NC}"
    fi
}

server_status() {
    echo -e "${BLUE}🖥️  Server Status:${NC}"
    echo ""
    
    # System resources
    echo -e "${YELLOW}Memory Usage:${NC}"
    free -h
    echo ""
    
    echo -e "${YELLOW}Disk Usage:${NC}"
    df -h | grep -vE '^Filesystem|tmpfs|cdrom'
    echo ""
    
    echo -e "${YELLOW}Running Containers:${NC}"
    docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
    echo ""
    
    echo -e "${YELLOW}Port Usage:${NC}"
    ss -tuln | grep -E ':80|:443|:8080|:8081|:8082|:3306|:3307|:3308|:6379|:6380'
}

# Main menu loop
while true; do
    show_menu
    read -p "Choose option (0-9): " choice
    
    case $choice in
        1) list_projects ;;
        2) start_project ;;
        3) stop_project ;;
        4) restart_project ;;
        5) view_logs ;;
        6) backup_project ;;
        7) echo "Update project feature - Coming soon!" ;;
        8) echo "Create new project feature - Coming soon!" ;;
        9) server_status ;;
        0) echo -e "${GREEN}Goodbye! 👋${NC}"; exit 0 ;;
        *) echo -e "${RED}Invalid option!${NC}" ;;
    esac
    
    echo ""
    read -p "Press Enter to continue..."
    clear
done 