@section('vue-scripts')
<% for (var chunk in htmlWebpackPlugin.files.chunks) { %>
<script src="<%= htmlWebpackPlugin.files.chunks[chunk].entry %>"></script>
<% } %>
@endsection

@section('vue-styles')
    <% for (var css in htmlWebpackPlugin.files.css) { %>
    <link href="<%= htmlWebpackPlugin.files.css[css] %>" rel="stylesheet">
    <% } %>
@endsection
