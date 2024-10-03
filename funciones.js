
var autoRefresh = true;
var intervalId;

function toggleHistorial() {
    var historialDiv = document.getElementById('historial');
    if (historialDiv.style.display === 'none') {
        historialDiv.style.display = 'block';
        clearInterval(intervalId); // Stop the auto-refresh
        autoRefresh = false;
    } else {
        historialDiv.style.display = 'none';
        autoRefresh = true;
        startAutoRefresh(); // Restart the auto-refresh
    }
}

function startAutoRefresh() {
    if (autoRefresh) {
        clearInterval(intervalId); // Ensure no multiple intervals are running
        intervalId = setInterval(function() {
            location.reload();
        }, 3000);
    }
}

window.onload = function() {
    startAutoRefresh();
};



