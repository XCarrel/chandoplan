document.addEventListener('DOMContentLoaded', function () {
    divMyActivities.addEventListener('click',function () {
        divMyActivities.classList.add('d-none')
        divAllActivities.classList.remove('d-none')
        document.querySelectorAll('.notMyActivities').forEach(function(act) {
            act.classList.add('d-none')
        });
    })
    divAllActivities.addEventListener('click',function () {
        divMyActivities.classList.remove('d-none')
        divAllActivities.classList.add('d-none')
        document.querySelectorAll('.notMyActivities').forEach(function(act) {
            act.classList.remove('d-none')
        });
    })
})
