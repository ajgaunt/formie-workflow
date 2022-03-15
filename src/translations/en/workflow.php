<?php

return [
    //
    // Email Messages
    //

    'workflow_publisher_notification_heading' => 'When an editor submits entry for approval:',
    'workflow_publisher_notification_subject' => '"{{ submission.getOwner().title }}" has been submitted for approval on {{ submission.getOwnerSite() }}.',
    'workflow_publisher_notification_body' => "Hey {{ user.friendlyName }},\n\n" .
        "{{ submission.editor }} has submitted the entry \"{{ submission.getOwner().title }}\" for approval on {{ submission.getOwnerSite() }}.\n\n" .
        "{% if submission.editorNotes %}Notes: \"{{ submission.editorNotes }}\"\n\n{% endif %}" .
        "To review it please log into your control panel.\n\n" .
        "{{ submission.cpEditUrl }}",

    'workflow_editor_review_notification_heading' => 'When a reviewer approves or rejects an editor submission:',
    'workflow_editor_review_notification_subject' => 'Your submission for "{{ submission.getOwner().title }}" has been {{ review.approved ? \'approved\' : \'rejected\' }} on {{ submission.getOwnerSite() }}.',
    'workflow_editor_review_notification_body' => "Hey {{ user.friendlyName }},\n\n" .
        "Your submission for {{ submission.getOwner().title }} has been {{ review.approved ? 'approved' : 'rejected' }} {{ review.dateCreated | date }} on {{ submission.getOwnerSite() }}.\n\n" .
        "{% if review.notes %}Notes: \"{{ review.notes }}\"\n\n{% endif %}" .
        "View your submission by logging into your control panel.\n\n" .
        "{{ submission.cpEditUrl }}",

    'workflow_editor_notification_heading' => 'When a publisher approves or rejects an editor submission:',
    'workflow_editor_notification_subject' => 'Your submission for "{{ submission.getOwner().title }}" has been {{ submission.status }} on {{ submission.getOwnerSite() }}.',
    'workflow_editor_notification_body' => "Hey {{ user.friendlyName }},\n\n" .
        "Your submission for {{ submission.getOwner().title }} has been {{ submission.status }} {{ (submission.status == 'approved') ? submission.dateApproved | date : submission.dateRejected | date }} on {{ submission.getOwnerSite() }}.\n\n" .
        "{% if submission.publisherNotes %}Notes: \"{{ submission.publisherNotes }}\"\n\n{% endif %}" .
        "View your submission by logging into your control panel.\n\n" .
        "{{ submission.cpEditUrl }}",
];
