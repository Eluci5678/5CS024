document.addEventListener('DOMContentLoaded', function() {
    const lastTab = localStorage.getItem('activeTab');

    if (lastTab) {
        const tabTrigger = document.querySelector(`#dashboardTabs button[data-bs-target="${lastTab}"]`);
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }

    const tabButtons = document.querySelectorAll('#dashboardTabs button[data-bs-toggle="tab"]');

    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
        });
    });
});