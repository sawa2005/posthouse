// Code by Samuel Ward

// Menyvariabler
const menuIcon = document.querySelector('.menuicon');
const navLinks = document.querySelector('.navlinks');
const body = document.querySelector('body');

// Öppna meny
menuIcon.addEventListener('click', function() {
    navLinks.classList.toggle('open');
    
    // Ser till att man inte kan skrolla med menyn öppen
    if (body.style.position != 'fixed') {
        body.style.position = 'fixed';
    }
    
    else if (body.style.position == 'fixed') {
        body.style.position = 'static';
    }
});

// Lägesbrytare
const checkbox = document.querySelector('#checkbox');
var checkboxStatus = checkbox.checked;

checkbox.addEventListener('change', function() {
    if (this.checked) {
        // Ändra till ljust tema
        document.body.classList.add('light');
        menuIcon.src = "img/burger_dark.png";
    }
    
    else {
        // Ändra till mörkt tema
        document.body.classList.remove('light');
        menuIcon.src = "img/burger.png";
    }
});

// Ser till att läget inte återställs efter uppdatering
var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {},
    $checkboxes = $("#checkbox-container :checkbox");

$checkboxes.on("change", function(){
    $checkboxes.each(function(){
        checkboxValues[this.id] = this.checked;
    });
    
    localStorage.setItem("checkboxValues", JSON.stringify(checkboxValues));
});

// Kollar vilket läge som senast användes och byter till det
$.each(checkboxValues, function(key, value) {
    $("#" + key).prop('checked', value);
    
    if (value == true) {
        $("*").addClass("notransition");
        
        document.body.classList.add('light');
        menuIcon.src = "img/burger_dark.png";
        document.body.offsetHeight;

        $("*").removeClass("notransition");
    }

    else {
        document.body.classList.remove('light');
        menuIcon.src = "img/burger.png";
    }
});