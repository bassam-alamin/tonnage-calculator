<!DOCTYPE html>
<html>
<head>
    <title>Edible Oil Tonnage Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    th {
        cursor: pointer;
        user-select: none;
    }
    .sort-arrow {
        margin-left: 5px;
        font-size: 0.9rem;
        color:  #0d6efd;

    }
    .sort-arrow.active {
        color: #0d6efd;
        font-weight: bold;
    }
</style>
</head>
<body class="p-4 bg-light">
    <div class="container">
        <h2 class="mb-4">Edible Oil Tonnage Calculator</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('oil.store') }}" class="mb-5">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Volume (litres)</label>
                    <input type="number" step="any" name="volume" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Density (kg/m³)</label>
                    <input type="number" step="any" name="density" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Temperature (°C)</label>
                    <input type="number" step="any" name="temperature" class="form-control" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary mt-3" type="submit">Calculate Tonnage</button>
                </div>
            </div>
        </form>

        <h4>Calculation History</h4>
        <input class="form-control mb-3" id="search" type="text" placeholder="Search..." onkeyup="searchTable()">

        <table class="table table-bordered" id="recordsTable">
<thead>
    <tr>
        <th onclick="sortTable(0, this)">Date <span class="sort-arrow"></span></th>
        <th onclick="sortTable(1, this)">Volume <span class="sort-arrow"></span></th>
        <th onclick="sortTable(2, this)">Density <span class="sort-arrow"></span></th>
        <th onclick="sortTable(3, this)">Temperature <span class="sort-arrow"></span></th>
        <th onclick="sortTable(4, this)">VCF <span class="sort-arrow"></span></th>
        <th onclick="sortTable(5, this)">Tonnage (MT) <span class="sort-arrow"></span></th>
    </tr>
</thead>

            <tbody>
                @foreach($records as $r)
                    <tr>
                        <td>{{ $r->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $r->volume }}</td>
                        <td>{{ $r->density }}</td>
                        <td>{{ $r->temperature }}</td>
                        <td>{{ $r->vcf }}</td>
                        <td>{{ $r->tonnage }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

{{ $records->links('pagination::bootstrap-5') }}
    </div>
    <script>
    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#recordsTable tbody tr");
        rows.forEach(row => {
            row.style.display = Array.from(row.cells).some(
                cell => cell.textContent.toLowerCase().includes(input)
            ) ? "" : "none";
        });
    }

    let sortDirection = true;

    function sortTable(columnIndex) {
        const table = document.getElementById("recordsTable");
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));

        rows.sort((a, b) => {
            const valA = a.children[columnIndex].textContent.trim();
            const valB = b.children[columnIndex].textContent.trim();

            const numA = parseFloat(valA.replace(/[^\d.-]/g, ''));
            const numB = parseFloat(valB.replace(/[^\d.-]/g, ''));

            const isNumeric = !isNaN(numA) && !isNaN(numB);
            if (isNumeric) {
                return sortDirection ? numA - numB : numB - numA;
            } else {
                return sortDirection
                    ? valA.localeCompare(valB)
                    : valB.localeCompare(valA);
            }
        });

        sortDirection = !sortDirection;

        rows.forEach(row => tbody.appendChild(row)); // re-append in new order
    }
</script>

</body>
</html>
