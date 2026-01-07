<h2>Website Recovered</h2>

<p><strong>Website:</strong> {{ $website->url }}</p>
<p><strong>Status:</strong> UP</p>
<p><strong>Checked at:</strong> {{ optional($website->last_checked_at)->toDayDateTimeString() }}</p>

<p>All good now.</p>
