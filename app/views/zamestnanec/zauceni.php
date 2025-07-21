<?php require_once(APPROOT . '/views/inc/header.php'); ?>

<h1>Zamestnanec zauceni</h1>



    
<form action="">
<label for="myBrowser">Vyberte Zaměstnance:</label>
<input list="ZamSkolit" required id="myBrowser" name="myBrowser"/>
<datalist id="ZamSkolit">
    <?php foreach($data['zamestnanci'] as $pole => $seznam): ?>  
        <?php echo "<option value=".$seznam['os'].">".$seznam['os_vyhledat']."</option>"; ?>
    <?php endforeach; ?>
</datalist>

</form>

<input list="cities" name="city" value="San Diego">
<datalist id="cities">
    <option value="San Diego">
    <option value="Del Mar">
    <option value="Solana Beach">
    <option value="Escondido">
    <option value="Carlsbad">
</datalist>


<select>
  <option value="Opt 1.">Opt 1.</option>
  <option class="optionselector" value="Opt 2. I'm disabled!" disabled="disabled">opt 2. I'm disabled!</option>
  <option value="Opt 3.">Opt 3.</option>
</select>


<script>

// JavaScript to handle the dropdown behavior and collect selected values

document.addEventListener('click', function(event) {

  var dropdown = document.querySelector('.dropdown-content');

  if (!dropdown.contains(event.target)) {

    dropdown.style.display = 'none';

  }

});


function getSelectedFruits() {

  var checkboxes = document.querySelectorAll('.dropdown-content input[type="checkbox"]');

  var selectedFruits = [];

  checkboxes.forEach(function(checkbox) {

    if (checkbox.checked) {

      selectedFruits.push(checkbox.value);

    }

  });

  return selectedFruits;

}


// Example usage

document.querySelector('.dropdown button').addEventListener('click', function() {

  console.log(getSelectedFruits());

});

</script>



<?php require_once(APPROOT . '/views/inc/footer.php'); ?>