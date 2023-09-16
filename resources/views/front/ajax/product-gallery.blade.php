@if(count($images) > 0)
    <style>
        .gallery-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            border-radius: 5px;
        }

        .main-gallery-image {
            width: 500px;
            height: 500px;
            overflow: hidden;
            position: relative;
            cursor: zoom-in;
            border-radius: 5px;
        }

        .main-gallery-image img {

            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-thumbnails {
            display: flex;
            justify-content: flex-start;
            overflow-x: auto;
            white-space: nowrap;
        }

        .gallery-thumbnail.selected {
            border: 2px solid orange;
        }

        .gallery-thumbnail {
            width: 40px;
            height: 40px;
            cursor: pointer;
            border: 1px solid rgba(255, 0, 86, 0.25);
            margin-right: 10px;
            display: inline-block;
            border-radius: 5px;
        }

        .gallery-thumbnail img {
            object-fit: cover;
            border-radius: 4px;
        }
    </style>

    <div class="gallery-container w-100 p-3 border border-opacity-50 border-1">
        <div class="main-gallery-image mw-100">
            <img src="{{ asset($images[$showcase_id ?? 0]) }}" alt="Ürün 1" class="w-100 h-100 border border-opacity-50 border-1">
        </div>
        <div class="gallery-thumbnails mt-2">
            @foreach($images as $key=>$item)
                <div class="gallery-thumbnail {{ $key == ($showcase_id ?? 0) ? "selected" : "" }}">
                    <img src="{{ asset($item) }}" alt="Ürün 1" class="w-100 h-100">
                </div>
            @endforeach
        </div>
    </div>

    <script>
        try {
            const mainImage = document.querySelector('.main-gallery-image img');
            const thumbnails = document.querySelectorAll('.gallery-thumbnail img');

            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', () => {
                    mainImage.src = thumbnail.src;

                    thumbnails.forEach((thumb) => {
                        thumb.parentElement.classList.remove('selected');
                    });

                    thumbnail.parentElement.classList.add('selected');
                });
            });

            const mainImageContainer = document.querySelector('.main-gallery-image');

            mainImageContainer.addEventListener('mousemove', (e) => {
                const {offsetX, offsetY, target} = e;
                const {offsetWidth, offsetHeight} = target;

                const x = (offsetX / offsetWidth) * 100;
                const y = (offsetY / offsetHeight) * 100;

                mainImage.style.transformOrigin = `${x}% ${y}%`;
                mainImage.style.transform = 'scale(3)';
            });

            mainImageContainer.addEventListener('mouseleave', () => {
                mainImage.style.transformOrigin = 'center';
                mainImage.style.transform = 'scale(1)';
            });
        } catch (e) {

        }
    </script>
@else
    <img src="{{ $product->image != null ? asset($product->image) : asset("images/cloth_1.jpg") }}"
         alt="{{ $product->name }}" class="img-fluid">
@endif


