$(document).ready(function () {

    $('#smartSearchBtn').on('click', function () {
        const keyword = $('#smartSearch').val().trim();

        if (!keyword) {
            alert('Please enter a search keyword');
            return;
        }

        $.ajax({
            url: '/smart-search',
            method: 'POST',
            data: {
                keyword: keyword,
                scope: $('#searchScope').val(),
                date_from: $('#dateFrom').val(),
                date_to: $('#dateTo').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (results) {
                renderSearchResults(results);
            },
            error: function () {
                alert('Search failed. Please try again.');
            }
        });
    });

});

/* ===============================
   Render Results
================================ */
function renderSearchResults(results) {
    let html = '';

    if (!results.length) {
        html = `
            <div class="alert alert-warning">
                No results found.
            </div>
        `;
    } else {
        html = '<ul class="list-group">';

        results.forEach(item => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${item.application_id}</strong><br>
                        <small>${item.title}</small>
                    </div>
                    <button class="btn btn-sm btn-success"
                        onclick='openResult(${JSON.stringify(item)})'>
                        View
                    </button>
                </li>
            `;
        });

        html += '</ul>';
    }
    $('#searchResults').html(html);
}


function openResult(item) {

    const routes = {
        nikah: '/nikah/view/',
        divorce: '/divorce/view/',
        inheritance: '/inheritance/view/',
        guardianship: '/guardianship/view/',
        convert: '/convert/view/'
    };

    if (!routes[item.module]) {
        alert('Invalid module');
        return;
    }

    window.location.href = routes[item.module] + item.reference_id;
}
