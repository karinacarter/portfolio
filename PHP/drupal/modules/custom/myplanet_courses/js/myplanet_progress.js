(function ($) {
        var percentage;

        percentage = drupalSettings.myplanet_courses.percentage/100;
        $('#block-masterprogressbar-4 div').circleProgress({
            value: percentage,
            startAngle: -Math.PI / 2,
            emptyFill: '#E6E6E',
            fill: {gradient: [['#E5E5E5', .5], ['#E5E5E5', .5]], gradientAngle: Math.PI / 4}
        }).on('circle-animation-progress', function(event, progress, stepValue) {
            $(this).find('strong').text(stepValue.toFixed(2).substr(1));
        });



  // Add in the percentage circle to the view.
  // field-node--field-percentage



  $('.field-node--field-percentage').circleProgress({
    value: .20,
    startAngle: -Math.PI / 2,
    size: 20,
    emptyFill: '#E6E6E',
    fill: {gradient: [['#E5E5E5', .5], ['#E5E5E5', .5]], gradientAngle: Math.PI / 4}
  }).on('circle-animation-progress', function(event, progress, stepValue) {
    $(this).find('strong').text(stepValue.toFixed(2).substr(1));
  });



    })(jQuery);
