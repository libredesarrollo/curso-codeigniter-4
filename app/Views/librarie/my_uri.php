<table class="table">
    <thead>
        <tr>
            <th>Esquema</th>
            <th>Auth</th>
            <th>Host</th>
            <th>Post</th>
            <th>Path</th>
            <th>Query</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $uri->getScheme() ?></td>
            <td><?= $uri->getAuthority() ?></td>
            <td><?= $uri->getHost() ?></td>
            <td><?= $uri->getPort() ?></td>
            <td><?= $uri->getPath() ?></td>
            <td><?= $uri->getQuery() ?></td>
            <td><?= $uri->getFragment() ?></td>
        </tr>
    </tbody>
</table>