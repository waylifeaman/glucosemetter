<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Topic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Add Topic
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('topics.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="instansi">Instansi</label>
                                <input type="text" name="instansi" id="instansi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="topic_pub">Publish Topic</label>
                                <input type="text" name="topic_pub" id="topic_pub" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="topic_sub">Subscribe Topic</label>
                                <input type="text" name="topic_sub" id="topic_sub" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Topic</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
