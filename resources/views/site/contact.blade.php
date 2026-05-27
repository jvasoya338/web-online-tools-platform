@extends('site.layout')

@section('content')
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Contact</div>
                    <h1 style="margin-top:16px;">Send a message to WebToolsStation</h1>
                    <p style="margin-top:16px;">
                        Use this form to report a bug, suggest a new tool, ask a business question, or share feedback about the platform.
                        Messages go directly to TJVerce for review.
                    </p>
                    <p style="margin-top:16px;">
                        WebToolsStation is operated by TJVerce. Based in {{ $contact['location'] }}. Contact: {{ $contact['email'] }}.
                    </p>
                </div>

                @if (session('status'))
                    <div class="page-section-card" style="border-color: rgba(15, 118, 110, 0.24); background: rgba(240, 253, 250, 0.85);">
                        <strong style="font-family: 'Trebuchet MS', 'Segoe UI', sans-serif;">Message sent</strong>
                        <p style="margin-top:10px;">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="page-section-card" style="border-color: rgba(185, 28, 28, 0.18); background: rgba(254, 242, 242, 0.92);">
                        <strong style="font-family: 'Trebuchet MS', 'Segoe UI', sans-serif;">Please check the form</strong>
                        <ul class="detail-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="page-section-card">
                    <h3>Contact form</h3>
                    <form class="tool-stack" style="margin-top:18px;" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="tool-inline two">
                            <input class="tool-field" type="text" name="name" value="{{ old('name') }}" placeholder="Your name">
                            <input class="tool-field" type="email" name="email" value="{{ old('email') }}" placeholder="Your email address">
                        </div>
                        <div class="tool-inline two">
                            <select class="tool-field" name="topic">
                                @foreach ($contact['topics'] as $topic)
                                    <option value="{{ $topic }}" @selected(old('topic') === $topic)>{{ $topic }}</option>
                                @endforeach
                            </select>
                            <input class="tool-field" type="text" name="subject" value="{{ old('subject') }}" placeholder="Short subject">
                        </div>
                        <input class="tool-field" type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute; left:-9999px; opacity:0;">
                        <textarea class="tool-field" name="message" placeholder="Write your message here with the page name, problem, or suggestion.">{{ old('message') }}</textarea>
                        <div class="tool-actions">
                            <button class="button button-primary" type="submit">Send message</button>
                            <a class="button button-secondary" href="mailto:webtoolsstation@gmail.com">Email directly</a>
                        </div>
                    </form>
                </div>

                <div class="page-sections" style="margin-top:24px;">
                    <article class="page-section-card">
                        <h3>What makes a helpful message</h3>
                        <p>
                            Clear messages help us respond faster. If you are reporting a problem, mention the exact tool page, what you entered,
                            what result you expected, and what happened instead. If you are suggesting a new tool, explain the task you want to solve
                            and who would benefit from it.
                        </p>
                        <p>
                            If the message is about a business request, collaboration, or content opportunity, include the main goal, the website or
                            company involved, and the best way to follow up with you.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>Response expectations</h3>
                        <p>
                            We review contact messages manually. Some requests are quick support questions, while others are feature ideas or platform
                            discussions that may take longer to review. Sending one complete message is usually better than sending several short ones.
                        </p>
                        <p>
                            WebToolsStation is still growing, so we focus first on messages that improve usability, trust, and practical value for visitors.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>What we can review from a contact request</h3>
                        <p>
                            Contact messages are most useful when they point to a specific page, tool, input type, browser, or workflow. For example, a message about the
                            JSON Formatter should mention whether the problem happened while formatting, minifying, copying output, or reading an error message. A message
                            about a PDF tool should mention the kind of PDF being checked, whether the file is password protected, and what result seemed unclear.
                        </p>
                        <p>
                            We cannot safely diagnose private production systems, confidential documents, legal disputes, financial decisions, or account security incidents
                            from a public contact form. In those cases, the best use of this form is to report a site issue or ask a general platform question while keeping
                            sensitive details out of the message. That helps us improve WebToolsStation without asking visitors to share information that belongs in a more
                            secure support or professional review process.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>Why this page exists</h3>
                        <p>
                            A real contact page is part of the trust structure for a public tools website. Visitors should be able to see who operates the platform, where the
                            project is based, what kinds of messages are appropriate, and how feedback is handled. This is especially important for browser tools because users
                            may be working with text, files, URLs, tokens, colors, or document signals that affect real work.
                        </p>
                        <p>
                            WebToolsStation uses this page for support questions, correction requests, tool suggestions, and business inquiries. The goal is not to create an
                            anonymous utility directory with no way to reach the operator. The goal is to keep the site accountable, improve pages when visitors find gaps, and
                            make it clear that TJVerce reviews the platform as an ongoing publishing and product project.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>What happens after feedback is reviewed</h3>
                        <p>
                            When feedback points to a real usability problem, we compare it with the affected page and decide whether the fix belongs in the tool interface,
                            the guide content, the metadata, or the surrounding trust information. Some changes are small, such as improving a label or adding a clearer warning.
                            Other changes require deeper review, especially when they affect browser-side file handling, generated output, structured data, or public policy text.
                        </p>
                        <p>
                            Tool suggestions are reviewed in the same practical way. A new idea should solve a clear task, fit the browser-based nature of the platform, and be
                            understandable without a complicated account workflow. If a suggestion is too broad, too sensitive for a lightweight utility, or better handled by
                            professional software, it may still influence a guide or limitation note even if it does not become a standalone tool immediately.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>Before sending sensitive information</h3>
                        <p>
                            Please avoid sending passwords, private API tokens, customer records, confidential PDF files, legal documents, medical information, payment details,
                            or internal business data through this form. If you need to describe a problem, use a reduced example that shows the issue without exposing real
                            sensitive content. For example, replace real names, IDs, domains, and account values with sample placeholders before sharing the message.
                        </p>
                        <p>
                            This keeps the conversation safer for both sides and helps us focus on the platform issue. WebToolsStation can improve labels, examples, guide notes,
                            validation behavior, and tool explanations from a sanitized report just as effectively as from a private production sample.
                        </p>
                    </article>
                </div>
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">Contact Details</div>
                        <h3 style="margin-top:14px;">Important details in one place</h3>
                    </div>
                    <div class="page-grid">
                        <div class="card">
                            <div class="tool-icon">TJ</div>
                            <h3 style="margin-top:12px;">Company</h3>
                            <p>{{ $contact['company'] }}</p>
                        </div>
                        <div class="card">
                            <div class="tool-icon">WS</div>
                            <h3 style="margin-top:12px;">Platform</h3>
                            <p>{{ $contact['platform'] }}</p>
                        </div>
                        <div class="card">
                            <div class="tool-icon">EM</div>
                            <h3 style="margin-top:12px;">Email</h3>
                            <p>{{ $contact['email'] }}</p>
                        </div>
                        <div class="card">
                            <div class="tool-icon">TP</div>
                            <h3 style="margin-top:12px;">Topics</h3>
                            <p>{{ implode(', ', $contact['topics']) }}</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
