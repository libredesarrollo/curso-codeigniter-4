<table class="table">
    <thead>
        <tr>
            <th>Ip</th>
            <th>Ip Valida</th>
            <th>Metodo</th>
            <th>Server</th>
            <th>Ajax</th>
            <th>Cli</th>
            <th>Secure</th>
            <th>Headers</th>
            <th>Uri</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $request->getIPAddress() ?></td>
            <td><?= $request->isValidIP($request->getIPAddress() )?></td>
            <td><?= $request->getMethod()?></td>
            <td><?= var_dump($request->getServer(['SERVER_PROTOCOL', 'REQUEST_URI']))?></td>
            <td><?= (int)$request->isAjax()?></td>
            <td><?= (int)$request->isCLI()?></td>
            <td><?= (int)$request->isSecure()?></td>
            <td><?= var_dump($request->getHeaders())?></td>
            <td><?= var_dump($request->uri)?></td>
            
        </tr>
    </tbody>
</table>