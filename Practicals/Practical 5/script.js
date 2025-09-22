class DataManager {
    constructor() {
        this.eventsData = [
            {
                id: 1,
                name: "Tech Conference 2025",
                date: "October 15-17, 2025",
                location: "Central Lawn",
                description: "Annual technology conference featuring industry leaders and cutting-edge innovations",
                category: "Technology",
                capacity: 500
            },
            {
                id: 2,
                name: "Career Fair",
                date: "November 5, 2025",
                location: "Multi Utility Building",
                description: "Meet top employers from various industries and explore career opportunities",
                category: "Career",
                capacity: 300
            },
            {
                id: 3,
                name: "Alumni Networking Event",
                date: "November 20, 2025",
                location: "Central Lawn",
                description: "Connect with successful alumni and build professional relationships",
                category: "Networking",
                capacity: 200
            },
            {
                id: 4,
                name: "Research Symposium",
                date: "December 10, 2025",
                location: "Academic Block",
                description: "Showcase of innovative research projects and academic achievements",
                category: "Academic",
                capacity: 150
            },
            {
                id: 5,
                name: "Cultural Festival",
                date: "January 15, 2026",
                location: "Main Auditorium",
                description: "Celebration of diverse cultures with performances and exhibitions",
                category: "Cultural",
                capacity: 800
            }
        ];

        this.studentsData = [
            {
                id: 101,
                name: "Aryan Parikh",
                email: "aryan81006@gmail.com",
                major: "Computer Science",
                year: "2",
                gpa: 3.8,
                status: "Active"
            },
            {
                id: 102,
                name: "Rudra Parikh",
                email: "rudra652@gmail.com",
                major: "Artificial Intelligence",
                year: "1",
                gpa: 3.9,
                status: "Active"
            },
            {
                id: 103,
                name: "Akshar Patel",
                email: "aksharpatel6262@gmail.com",
                major: "Business Administration",
                year: "3",
                gpa: 3.7,
                status: "Active"
            },
            {
                id: 104,
                name: "Priya Shah",
                email: "priya.shah@university.edu",
                major: "Data Science",
                year: "2",
                gpa: 3.85,
                status: "Active"
            },
            {
                id: 105,
                name: "Rahul Kumar",
                email: "rahul.kumar@university.edu",
                major: "Mechanical Engineering",
                year: "4",
                gpa: 3.6,
                status: "Active"
            }
        ];
    }

    parseJSON(data) {
        const jsonString = JSON.stringify(data);
        return JSON.parse(jsonString);
    }

    getEvents() {
        return this.parseJSON(this.eventsData);
    }

    getStudents() {
        return this.parseJSON(this.studentsData);
    }

    filterData(data, filterFn) {
        return data.filter(filterFn);
    }

    sortData(data, key, ascending = true) {
        return [...data].sort((a, b) => {
            if (ascending) {
                return a[key] > b[key] ? 1 : -1;
            }
            return a[key] < b[key] ? 1 : -1;
        });
    }
}

class PaginationManager {
    constructor(data, itemsPerPage = 3) {
        this.data = data;
        this.itemsPerPage = itemsPerPage;
        this.currentPage = 1;
    }

    setItemsPerPage(items) {
        this.itemsPerPage = items;
        this.currentPage = 1;
    }

    getTotalPages() {
        return Math.ceil(this.data.length / this.itemsPerPage);
    }

    getCurrentPageData() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        return this.data.slice(startIndex, endIndex);
    }

    nextPage() {
        if (this.currentPage < this.getTotalPages()) {
            this.currentPage++;
            return true;
        }
        return false;
    }

    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            return true;
        }
        return false;
    }

    getPageInfo() {
        return {
            current: this.currentPage,
            total: this.getTotalPages(),
            hasNext: this.currentPage < this.getTotalPages(),
            hasPrev: this.currentPage > 1
        };
    }
}

class UIRenderer {
    static renderEvent(event) {
        return `
            <div class="card">
                <h3>${event.name}</h3>
                <div class="card-detail">
                    <span class="label">Date:</span> ${event.date}
                </div>
                <div class="card-detail">
                    <span class="label">Location:</span> ${event.location}
                </div>
                <div class="card-detail">
                    <span class="label">Category:</span> ${event.category}
                </div>
                <div class="card-detail">
                    <span class="label">Capacity:</span> ${event.capacity} attendees
                </div>
                <div class="card-detail">
                    <span class="label">Description:</span> ${event.description}
                </div>
            </div>
        `;
    }

    static renderStudent(student) {
        return `
            <div class="card student-card">
                <h3>${student.name}</h3>
                <div class="card-detail">
                    <span class="label">Major:</span> ${student.major}
                </div>
                <div class="card-detail">
                    <span class="label">Year:</span> ${student.year}
                </div>
                <div class="card-detail">
                    <span class="label">GPA:</span> ${student.gpa}
                </div>
                <div class="card-detail">
                    <span class="label">Status:</span> ${student.status}
                </div>
                <div class="card-detail">
                    <span class="label">Email:</span> ${student.email}
                </div>
            </div>
        `;
    }

    static updatePaginationControls(type, pageInfo) {
        const prevBtn = document.getElementById(`${type}-prev`);
        const nextBtn = document.getElementById(`${type}-next`);
        const pageInfoEl = document.getElementById(`${type}-page-info`);

        prevBtn.disabled = !pageInfo.hasPrev;
        nextBtn.disabled = !pageInfo.hasNext;
        pageInfoEl.textContent = `Page ${pageInfo.current} of ${pageInfo.total}`;
    }
}

class App {
    constructor() {
        this.dataManager = new DataManager();
        this.events = this.dataManager.getEvents();
        this.students = this.dataManager.getStudents();
        
        this.eventsPagination = new PaginationManager(this.events, 3);
        this.studentsPagination = new PaginationManager(this.students, 3);
        
        this.init();
    }

    init() {
        this.updateStats();
        this.renderEvents();
        this.renderStudents();
        this.setupEventListeners();
    }

    updateStats() {
        document.getElementById('total-events').textContent = this.events.length;
        document.getElementById('total-students').textContent = this.students.length;
    }

    renderEvents() {
        const grid = document.getElementById('events-grid');
        const currentData = this.eventsPagination.getCurrentPageData();
        
        grid.innerHTML = currentData
            .map(event => UIRenderer.renderEvent(event))
            .join('');
        
        UIRenderer.updatePaginationControls('events', this.eventsPagination.getPageInfo());
    }

    renderStudents() {
        const grid = document.getElementById('students-grid');
        const currentData = this.studentsPagination.getCurrentPageData();
        
        grid.innerHTML = currentData
            .map(student => UIRenderer.renderStudent(student))
            .join('');
        
        UIRenderer.updatePaginationControls('students', this.studentsPagination.getPageInfo());
    }

    setupEventListeners() {
        document.getElementById('events-prev').addEventListener('click', () => {
            if (this.eventsPagination.prevPage()) {
                this.renderEvents();
            }
        });

        document.getElementById('events-next').addEventListener('click', () => {
            if (this.eventsPagination.nextPage()) {
                this.renderEvents();
            }
        });

        document.getElementById('students-prev').addEventListener('click', () => {
            if (this.studentsPagination.prevPage()) {
                this.renderStudents();
            }
        });

        document.getElementById('students-next').addEventListener('click', () => {
            if (this.studentsPagination.nextPage()) {
                this.renderStudents();
            }
        });

        document.getElementById('events-per-page').addEventListener('change', (e) => {
            this.eventsPagination.setItemsPerPage(parseInt(e.target.value));
            this.renderEvents();
        });

        document.getElementById('students-per-page').addEventListener('change', (e) => {
            this.studentsPagination.setItemsPerPage(parseInt(e.target.value));
            this.renderStudents();
        });
    }
}

function toggleJSON(type) {
    const jsonViewer = document.getElementById(`${type}-json`);
    const isVisible = jsonViewer.style.display !== 'none';
    
    if (isVisible) {
        jsonViewer.style.display = 'none';
    } else {
        const data = type === 'events' ? app.events : app.students;
        jsonViewer.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
        jsonViewer.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.app = new App();
});