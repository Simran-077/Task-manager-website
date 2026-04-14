<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #334155; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; letter-spacing: -0.5px; }
        .content { padding: 40px; line-height: 1.6; }
        .task-card { background: #f1f5f9; border-radius: 12px; padding: 25px; margin: 25px 0; border-left: 4px solid #6366f1; }
        .task-title { font-size: 18px; font-weight: bold; color: #1e293b; margin-bottom: 10px; }
        .task-meta { font-size: 14px; color: #64748b; margin-bottom: 5px; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #94a3b8; background: #f8fafc; }
        .btn { display: inline-block; padding: 12px 24px; background: #6366f1; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mission Assigned</h1>
        </div>
        <div class="content">
            <p>Hello there,</p>
            <p>A new assignment has been deployed to your dashboard. Here are the operation details:</p>
            
            <div class="task-card">
                <div class="task-title">{{ $task->title }}</div>
                <div class="task-meta"><strong>Deadline:</strong> {{ $task->deadline ? $task->deadline->format('M d, Y H:i') : 'No deadline' }}</div>
                <div class="task-meta"><strong>Priority:</strong> {{ ucfirst($task->priority) }}</div>
                <p style="margin-top: 15px; color: #475569;">{{ $task->description }}</p>
            </div>

            <center>
                <a href="{{ config('app.url') }}/tasks" class="btn">View Assignment</a>
            </center>

            <p style="margin-top: 40px; font-size: 14px;">Good luck with the task!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} TaskFlow Premium. All rights reserved.
        </div>
    </div>
</body>
</html>