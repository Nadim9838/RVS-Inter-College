$(document).ready(function () {

	$('#js-main-slider').pogoSlider({
		autoplay: true,
		autoplayTimeout: 5000,
		displayProgess: true,
		preserveTargetSize: true,
		targetWidth: 1000,
		targetHeight: 300,
		responsive: true
	}).data('plugin_pogoSlider');

	var transitionDemoOpts = {
		displayProgess: false,
		generateNav: false,
		generateButtons: false
	}

});

document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_news_and_events.php')
        .then(response => response.json())
        .then(data => {
            const newsContainer = document.getElementById('news-content');
            const eventsContainer = document.getElementById('events-content');
            
            data.news.forEach(newsItem => {
                const newsElement = document.createElement('div');
                newsElement.innerHTML = `<h4>${newsItem.title}</h4><p>${newsItem.content}</p><p>${newsItem.date}</p>`;
                newsContainer.appendChild(newsElement);
            });

            data.events.forEach(eventItem => {
                const eventElement = document.createElement('div');
                eventElement.innerHTML = `<h4>${eventItem.title}</h4><p>${eventItem.content}</p><p>${eventItem.date}</p>`;
                eventsContainer.appendChild(eventElement);
            });
        });
});

function updateTime() {
	const now = new Date();
	const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
	const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
	const dateStr = now.toLocaleDateString('en-IN', optionsDate);
	let timeStr = now.toLocaleTimeString('en-IN', optionsTime);
	timeStr = timeStr.replace(/(am|pm)/i, (match) => match.toUpperCase());
	document.getElementById('current-date').textContent = dateStr;
	document.getElementById('current-time').textContent = timeStr;
}

setInterval(updateTime, 1000); // Update every second
updateTime(); // Initial call to display time immediately

