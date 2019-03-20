<div class="header-text">

    <div class="header-gravatar">
        <?php

        $size = 50;
        ?>
        @if(!empty($entity->profile_image))

            <?php

            $imageUrl = config('app.url') . '/' . config('contacts.profile_picture_path') . $entity->profile_image;

            $format = '<img src="%1$s" width="%2$s" heigh="%2$s" />';

            echo sprintf($format, $imageUrl, $size);

            ?>

        @else

            <?php

            $image = md5(strtolower($entity->email));

            $imageUrl = "https://www.gravatar.com/avatar/" . $image . "?s=" . $size . "&d=".config('bap.gravatar_default_preview')."&r=PG";

            $format = '<img src="%1$s" width="%2$s" heigh="%2$s" />';

            echo sprintf($format, $imageUrl, $size);

            ?>
        @endif

    </div>

    {{ $entity->full_name }}
    <small>{{ $entity->email }} / {{ $entity->phone }}</small>
</div>