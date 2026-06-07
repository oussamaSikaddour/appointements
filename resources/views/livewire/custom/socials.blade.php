<ul class="socials">
    @foreach ($socialLinks as $platform => $link)
        @if ($link)
            @php
                $icons = [
                    'youtube' => 'fa-youtube',
                    'facebook' => 'fa-facebook',
                    'instagram' => 'fa-instagram',
                    'ticktock' => 'fa-tiktok',
                    'linkedin' => 'fa-linkedin',
                    'github' => 'fa-github',
                ];
            @endphp

            @if (array_key_exists($platform, $icons))
                <li>
                    <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($platform) }}">
                        <i class="fa-brands {{ $icons[$platform] }}"></i>
                    </a>
                </li>
            @endif
        @endif
    @endforeach
</ul>
