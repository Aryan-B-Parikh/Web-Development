// Quick fix for mathspresentation.html topology generation
// Add this to the console to test if the functions work

// Test if DOM elements exist
console.log('Canvas:', document.getElementById('canvasWrap'));
console.log('Generate Star:', document.getElementById('generateStar'));
console.log('Generate Mesh:', document.getElementById('generateMesh'));
console.log('Generate Hybrid:', document.getElementById('generateHybrid'));

// Simple working topology generation functions
function testStarGeneration() {
    console.log('Testing star generation...');
    
    // Clear existing
    const canvas = document.getElementById('canvasWrap');
    if (!canvas) {
        console.error('Canvas not found');
        return;
    }
    
    // Clear the canvas
    canvas.innerHTML = '';
    
    // Create nodes directly
    const centerNode = document.createElement('div');
    centerNode.style.cssText = 'position:absolute;left:250px;top:200px;width:40px;height:40px;border-radius:50%;background:#4ecdc4;color:white;display:flex;align-items:center;justify-content:center;font-weight:bold;';
    centerNode.textContent = 'C';
    centerNode.setAttribute('data-node', 'C');
    canvas.appendChild(centerNode);
    
    // Create surrounding nodes
    const nodeNames = ['A', 'B', 'D', 'E', 'F'];
    const radius = 120;
    
    nodeNames.forEach((name, i) => {
        const angle = (i * 2 * Math.PI) / nodeNames.length;
        const x = 250 + radius * Math.cos(angle);
        const y = 200 + radius * Math.sin(angle);
        
        const node = document.createElement('div');
        node.style.cssText = `position:absolute;left:${x}px;top:${y}px;width:40px;height:40px;border-radius:50%;background:#4ecdc4;color:white;display:flex;align-items:center;justify-content:center;font-weight:bold;`;
        node.textContent = name;
        node.setAttribute('data-node', name);
        canvas.appendChild(node);
    });
    
    console.log('Star topology created!');
    
    // Update the output
    const routingContent = document.getElementById('routingContent');
    if (routingContent) {
        routingContent.innerHTML = 'Star topology generated with 6 nodes using direct method';
    }
}

function testMeshGeneration() {
    console.log('Testing mesh generation...');
    
    const canvas = document.getElementById('canvasWrap');
    if (!canvas) {
        console.error('Canvas not found');
        return;
    }
    
    canvas.innerHTML = '';
    
    const nodeNames = ['A', 'B', 'C', 'D'];
    const positions = [
        {x: 150, y: 100},
        {x: 350, y: 100}, 
        {x: 350, y: 300},
        {x: 150, y: 300}
    ];
    
    nodeNames.forEach((name, i) => {
        const {x, y} = positions[i];
        const node = document.createElement('div');
        node.style.cssText = `position:absolute;left:${x}px;top:${y}px;width:40px;height:40px;border-radius:50%;background:#4ecdc4;color:white;display:flex;align-items:center;justify-content:center;font-weight:bold;`;
        node.textContent = name;
        node.setAttribute('data-node', name);
        canvas.appendChild(node);
    });
    
    console.log('Mesh topology created!');
    
    const routingContent = document.getElementById('routingContent');
    if (routingContent) {
        routingContent.innerHTML = 'Mesh topology generated with 4 nodes using direct method';
    }
}

// Test the functions
console.log('You can now run:');
console.log('testStarGeneration() - to create star topology');
console.log('testMeshGeneration() - to create mesh topology');