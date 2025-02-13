   <!--   Core JS Files   -->
   <script src="bootstrap-template/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="bootstrap-template/assets/js/core/popper.min.js"></script>
    <script src="bootstrap-template/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="bootstrap-template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="bootstrap-template/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="bootstrap-template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="bootstrap-template/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="bootstrap-template/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="bootstrap-template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="bootstrap-template/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="bootstrap-template/assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="bootstrap-template/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="bootstrap-template/assets/js/kaiadmin.min.js"></script>


    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>



<script>
    document.getElementById('search').addEventListener('keyup', function() {
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('.logs-column-body tr');

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let match = false;

        cells.forEach(cell => {
            // Ignore cells that contain buttons to prevent modification
            if (cell.querySelector('button') || cell.querySelector('a')) {
                return;
            }

            const text = cell.textContent.toLowerCase();
            if (text.includes(query)) {
                match = true;
                highlightCell(cell, query);
            } else {
                removeHighlight(cell);
            }
        });

        row.style.display = match ? '' : 'none';
    });
});

// Function to highlight matched text without removing elements
function highlightCell(cell, query) {
    const text = cell.textContent;
    const regex = new RegExp(`(${query})`, 'gi');
    cell.innerHTML = text.replace(regex, '<span style="background-color: yellow;">$1</span>');
}

// Function to remove highlights
function removeHighlight(cell) {
    cell.innerHTML = cell.textContent;
}
</script>
