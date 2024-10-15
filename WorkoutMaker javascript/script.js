$(document).ready(function () {
    let data; // Declareer data in een bredere scope

    // Laad oefeningen vanuit JSON
    $.getJSON('exercises.json', function (jsonData) {
        data = jsonData; // Ken jsonData toe aan de data-variabele
        // Toon oefeningen in de lijst met oefeningen
        displayExercises(data);

        // Laad het opgeslagen trainingsplan vanuit JSON
        loadWorkoutPlan();

        // Behandel klik op de knop "Toevoegen aan Plan"
        $('#exercises').on('click', '.add-to-plan', function () {
            const exerciseId = $(this).data('id');
            const selectedExercise = data.find(exercise => exercise.id === exerciseId);

            // Voeg de geselecteerde oefening toe aan het trainingsplan
            addExerciseToPlan(selectedExercise);

            // Sla het bijgewerkte trainingsplan op naar JSON
            saveWorkoutPlan();
        });
    });
    
    $('#selected-exercises').on('click', '.delete-from-plan', function () {
        const exerciseId = $(this).data('id');
        removeExerciseFromPlan(exerciseId);
        saveWorkoutPlan(); // Sla het bijgewerkte trainingsplan op na het verwijderen van een oefening
    });

    // Behandel veranderingen in de categorie dropdown
    $('#category-filter').change(function () {
        const selectedCategory = $(this).val();
        const filteredExercises = data.filter(exercise => !selectedCategory || exercise.category === selectedCategory);
        displayExercises(filteredExercises);
    });

    function displayExercises(exercises) {
        const exerciseList = $('#exercises');
        exerciseList.empty();

        exercises.forEach(exercise => {
            const listItem = $('<li>').text(exercise.name);
            const addButton = $('<button>').text('Toevoegen aan Plan').addClass('add-to-plan').data('id', exercise.id);
            const youtubeButton = $('<button>').text('Bekijk Video').addClass('watch-video').data('url', exercise.youtubeVideoUrl);

            listItem.append(addButton, youtubeButton);
            exerciseList.append(listItem);
        });

        // Behandel klik op de "Bekijk Video" knop
        $('.watch-video').on('click', function () {
            const videoUrl = $(this).data('url');
            openYouTubeVideo(videoUrl);
        });
    }

    function addExerciseToPlan(exercise) {
        const workoutPlanList = $('#selected-exercises');
        const listItem = $('<li>').text(exercise.name).data('id', exercise.id);

        // Voeg een verwijderknop toe voor elke oefening
        const deleteButton = $('<button>').text('Verwijderen').addClass('delete-from-plan').data('id', exercise.id);
        listItem.append(deleteButton);

        workoutPlanList.append(listItem);
    }

    function removeExerciseFromPlan(exerciseId) {
        $('#selected-exercises li').each(function () {
            if ($(this).data('id') === exerciseId) {
                $(this).remove();
                return false; // Verlaat de lus na het verwijderen van de oefening
            }
        });
    }

    function saveWorkoutPlan() {
        const workoutPlan = [];

        // Haal de tekst en data-id attribuut op van elke geselecteerde oefening
        $('#selected-exercises li').each(function () {
            const exerciseId = $(this).data('id');
            const exerciseName = $(this).text();
            workoutPlan.push({ id: exerciseId, name: exerciseName });
        });

        // Voer een AJAX-verzoek uit om het trainingsplan op te slaan naar een JSON-bestand
        $.ajax({
            type: 'POST',
            url: 'saveWorkoutPlan.php',
            contentType: 'application/json',
            data: JSON.stringify(workoutPlan),
            success: function (response) {
                console.log('Trainingsplan succesvol opgeslagen.');
            },
            error: function (error) {
                console.error('Fout bij het opslaan van het trainingsplan:', error);
            }
        });
    }

    function loadWorkoutPlan() {
        // Voer een AJAX-verzoek uit om het trainingsplan te laden vanuit een JSON-bestand
        $.getJSON('loadWorkoutPlan.php', function (savedPlan) {
            const workoutPlanList = $('#selected-exercises');

            // Toon het geladen trainingsplan
            savedPlan.forEach(exercise => {
                const listItem = $('<li>').text(exercise.name).data('id', exercise.id);
                const deleteButton = $('<button>').text('Verwijderen').addClass('delete-from-plan').data('id', exercise.id);
                listItem.append(deleteButton);
                workoutPlanList.append(listItem);
            });
        });
    }

    // Functie om een YouTube-video te openen in een nieuw venster/tabblad
    function openYouTubeVideo(videoUrl) {
        window.open(videoUrl, '_blank');
    }
});
