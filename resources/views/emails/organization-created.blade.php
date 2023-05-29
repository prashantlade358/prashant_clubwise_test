Hi {{ $data['user']->name }},

Congratulations! Your organization "{{ $data['organization']->name }}" has been created.

Here are the details:
- Organization ID: {{ $data['organization']->id }}
- Trial End Date: {{ $data['organization']->trial_end_date->format('Y-m-d H:i:s') }}

Thank you,
Your App
