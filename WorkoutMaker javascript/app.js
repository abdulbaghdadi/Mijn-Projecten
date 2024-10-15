$(document).ready(function () {
    // Function to load content dynamically
    function loadContent(url, targetElement) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                $(targetElement).html(data);
            },
            error: function () {
                $(targetElement).html('<p>Error loading content.</p>');
            }
        });
    }

    // Load initial content on page load
    loadContent('exercises.html', '#exercise-content');

    // Handle navigation clicks
    $('nav a').click(function (event) {
        event.preventDefault();
        const targetPage = $(this).attr('href');
        const targetElement = targetPage === 'exercises.html' ? '#exercise-content' : '#workout-content';

        // Load the content dynamically
        loadContent(targetPage, targetElement);
    });
});
