<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href=<?php echo URLROOT."public/css/tab.css";?>>
<title>ISOMAT 2</title>

</head>

<body>

<table class="table">
  <thead>
    <tr class="hlavicka">
    <?php  foreach($data[0] as $sloupec => $hodnota)  echo " <th> <input type=\"text\" class=\"search-input\" placeholder=\"$sloupec\"> </th>";?>
    </tr>
    </thead>
    <div class="scroll">
    <tbody>
    <?php foreach ($data as $klic => $klic1): ?>
  <?php echo "<tr>"; ?>
  <?php //if ($klic ===0) var_dump($klic1); ?>
  <?php foreach ($klic1 as $klicTab => $hodnotaTab): ?>
    <?php echo "<td>$hodnotaTab</td>"; ?>
      
    <?php endforeach; ?>
    <?php echo "</tr>"; ?>
  <?php endforeach; ?>
  </tbody>
  </div>
</table>
</body>


<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".search-input").forEach((inputField) => {
    const tableRows = inputField
      .closest("table")
      .querySelectorAll("tbody > tr");
      //console.log(tableRows);
    const headerCell = inputField.closest("th");
    //console.log(headerCell);
    const otherHeaderCells = headerCell.closest("tr").children;
    //console.dir(otherHeaderCells);
    const columnIndex = Array.from(otherHeaderCells).indexOf(headerCell);
    const searchableCells = Array.from(tableRows).map(
      (row) => row.querySelectorAll("td")[columnIndex]
    );
    console.log(searchableCells);
    inputField.addEventListener("input", () => {
      const searchQuery = inputField.value.toLowerCase();

      for (const tableCell of searchableCells) {
        const row = tableCell.closest("tr");
        const value = tableCell.textContent.toLowerCase().replace(",", "");
        
        row.style.visibility = null;

        if (value.search(searchQuery) === -1) {
          row.style.visibility = "collapse";
        }
      }
    }); 
  }); 
});

</script>

</html> 