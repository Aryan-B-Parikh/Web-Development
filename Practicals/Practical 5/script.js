// Simple data arrays
const events = [
    {
        name: "Tech Conference 2025",
        date: "October 15, 2025",
        location: "Central Lawn",
        description: "Annual technology conference"
    },
    {
        name: "Career Fair",
        date: "November 5, 2025", 
        location: "Multi Utility Building",
        description: "Meet top employers"
    },
    {
        name: "Alumni Meeting",
        date: "November 20, 2025",
        location: "Main Hall",
        description: "Connect with alumni"
    }
];

const students = [
    {
        name: "Aryan Parikh",
        email: "aryan81006@gmail.com",
        major: "Computer Science",
        year: "2"
    },
    {
        name: "Rudra Parikh", 
        email: "rudra652@gmail.com",
        major: "AI",
        year: "1"
    },
    {
        name: "Akshar Patel",
        email: "akshar@gmail.com",
        major: "Business",
        year: "3"
    }
];

// Display events on page load
window.onload = function() {
    displayEvents();
    displayStudents();
};

function displayEvents() {
    const eventsList = document.getElementById('events-list');
    let html = '';
    
    // Loop through events array
    for (let i = 0; i < events.length; i++) {
        html += '<div class="item">';
        html += '<h3>' + events[i].name + '</h3>';
        html += '<p><strong>Date:</strong> ' + events[i].date + '</p>';
        html += '<p><strong>Location:</strong> ' + events[i].location + '</p>';
        html += '<p>' + events[i].description + '</p>';
        html += '</div>';
    }
    
    eventsList.innerHTML = html;
}

function displayStudents() {
    const studentsList = document.getElementById('students-list');
    let html = '';
    
    // Loop through students array  
    for (let i = 0; i < students.length; i++) {
        html += '<div class="item">';
        html += '<h3>' + students[i].name + '</h3>';
        html += '<p><strong>Major:</strong> ' + students[i].major + '</p>';
        html += '<p><strong>Year:</strong> ' + students[i].year + '</p>';
        html += '<p><strong>Email:</strong> ' + students[i].email + '</p>';
        html += '</div>';
    }
    
    studentsList.innerHTML = html;
}

function showEventsJSON() {
    const jsonDiv = document.getElementById('events-json');
    
    if (jsonDiv.style.display === 'none') {
        // Convert array to JSON string
        const jsonString = JSON.stringify(events, null, 2);
        jsonDiv.innerHTML = '<pre>' + jsonString + '</pre>';
        jsonDiv.style.display = 'block';
    } else {
        jsonDiv.style.display = 'none';
    }
}

function showStudentsJSON() {
    const jsonDiv = document.getElementById('students-json');
    
    if (jsonDiv.style.display === 'none') {
        // Convert array to JSON string
        const jsonString = JSON.stringify(students, null, 2);
        jsonDiv.innerHTML = '<pre>' + jsonString + '</pre>';
        jsonDiv.style.display = 'block';
    } else {
        jsonDiv.style.display = 'none';
    }
}

// Demonstrate JSON parsing
function parseJSONExample() {
    // Create JSON string
    const eventsJSON = JSON.stringify(events);
    console.log('JSON String:', eventsJSON);
    
    // Parse JSON back to object
    const parsedEvents = JSON.parse(eventsJSON);
    console.log('Parsed Object:', parsedEvents);
    
    return parsedEvents;
}