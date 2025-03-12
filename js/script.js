function addToFavorites(id) {
    fetch('favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=add&id=' + id,
    })
    .then(response => response.text())
    .then(data => alert(data));
}

function removeFromFavorites(id) {
    fetch('favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=remove&id=' + id,
    })
    .then(response => response.text())
    .then(data => alert(data));
}

function addToWatchlist(id) {
    fetch('watchlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=add&id=' + id,
    })
    .then(response => response.text())
    .then(data => alert(data));
}

function removeFromWatchlist(id) {
    fetch('watchlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=remove&id=' + id,
    })
    .then(response => response.text())
    .then(data => alert(data));
}

function markAsViewed(id) {
    fetch('viewed.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=add&id=' + id,
    })
    .then(response => response.text())
    .then(data => alert(data));
}

function removeFromViewed(id) {
    fetch('viewed.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=remove&id=' + id,
    })
    .then(response => response.text())
    .then(data => alert(data));
}