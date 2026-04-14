<button {{ $attributes->merge(['type' => 'submit', 'class' => 'premium-btn w-full !text-white flex justify-center !text-sm']) }}>
    {{ $slot }}
</button>
