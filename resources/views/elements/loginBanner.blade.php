<div id="logBanner" class="col-xl-6 rounded-3 position-relative overflow-hidden">
    <?php
        $imageNames = ['perro.jpg', 'gato.jpg', 'ave.jpg'];
        $randomImageName = $imageNames[rand(0, count($imageNames) - 1)];
    ?>
    <img src="{{ asset('img/' . $randomImageName) }}" alt="Banner principal" class="img-fluid">
    <svg class="circle1" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <circle fill="#00A9EF" cx="50" cy="50" r="50" />
    </svg>
    <svg class="circle2" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <circle fill="#00A9EF" cx="50" cy="50" r="50" />
    </svg>
</div>