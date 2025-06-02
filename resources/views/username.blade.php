<form method="POST" action="{{ route('set-username') }}" class="username-form">
    @csrf
    <input type="text" name="username" placeholder="Enter your username" class="username-input">
    <button type="submit">Start Chat</button>
</form>
