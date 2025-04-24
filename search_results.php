<?php
// search_results.php

// ... Code précédent ...

foreach ($results as $item) {
    echo '<div class="card">';
    echo '<div class="card-image-container" style="position:relative;">';
    echo '<img src="' . $item['image_url'] . '" alt="' . htmlspecialchars($item['title'] ?? $item['name']) . '" class="card-image">';
    
    if ($item['type'] === 'movie') {
        // Année en haut à gauche
        echo '<span class="card-badge card-badge-left">' . (isset($item['release_date']) ? substr($item['release_date'], 0, 4) : '') . '</span>';
        // Note en haut à droite
        echo '<span class="card-badge card-badge-right">' . (isset($item['vote_average']) ? round($item['vote_average'], 1) : '') . '</span>';
    } elseif ($item['type'] === 'tv') {
        // Année en haut à gauche
        echo '<span class="card-badge card-badge-left">' . (isset($item['first_air_date']) ? substr($item['first_air_date'], 0, 4) : '') . '</span>';
        // Note en haut à droite
        echo '<span class="card-badge card-badge-right">' . (isset($item['vote_average']) ? round($item['vote_average'], 1) : '') . '</span>';
    } elseif ($item['type'] === 'person') {
        // Âge en haut à gauche
        if (isset($item['birthday'])) {
            $birth = new DateTime($item['birthday']);
            $now = new DateTime();
            $age = $now->diff($birth)->y;
            echo '<span class="card-badge card-badge-left">' . $age . ' ans</span>';
        }
        // Rien à droite
    } elseif ($item['type'] === 'collection') {
        // Année du 1er film à gauche, dernier film à droite
        if (isset($item['parts']) && count($item['parts']) > 0) {
            $years = array_map(function($part) {
                return isset($part['release_date']) ? substr($part['release_date'], 0, 4) : null;
            }, $item['parts']);
            $years = array_filter($years);
            if (count($years) > 0) {
                $first = min($years);
                $last = max($years);
                echo '<span class="card-badge card-badge-left">' . $first . '</span>';
                echo '<span class="card-badge card-badge-right">' . $last . '</span>';
            }
        }
    }
    echo '</div>'; // card-image-container

    // Titre
    echo '<div class="card-title">' . htmlspecialchars($item['title'] ?? $item['name']) . '</div>';

    // Synopsis ou description
    if ($item['type'] === 'movie' && !empty($item['overview'])) {
        echo '<div class="card-overview">' . htmlspecialchars(mb_substr($item['overview'], 0, 120)) . '...</div>';
    } elseif ($item['type'] === 'tv' && !empty($item['overview'])) {
        echo '<div class="card-overview">' . htmlspecialchars(mb_substr($item['overview'], 0, 120)) . '...</div>';
    }
    echo '</div>'; // card
}