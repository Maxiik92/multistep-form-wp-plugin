<html>

<head>
  <style>
    table th {
      text-align: left;
      padding-right: 15px;
    }
  </style>
</head>

<body>
  <h2>New Form Submission</h2>
  <p>There was a new form submission on your wordpress page</p>

  <table>
    <tr>
      <th>Submitted on</th>
      <td><?php echo date('h:i:s d.m.Y') ?></td>
    </tr>
    <tr>
      <th>Name</th>
      <td><?php echo esc_html($formData['name'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?php echo esc_html($formData['email'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Phone Number</th>
      <td><?php echo esc_html($formData['phone_number'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Country</th>
      <td><?php echo esc_html($formData['country'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Company</th>
      <td><?php echo esc_html($formData['company'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Address</th>
      <td><?php echo esc_html($formData['address'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Postal Code</th>
      <td><?php echo esc_html($formData['postal_code'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Age</th>
      <td><?php echo esc_html($formData['age']) ?? ''; ?></td>
    </tr>
    <tr>
      <th>Music Genre</th>
      <td><?php echo esc_html($formData['music_genre'] ?? ''); ?></td>
    </tr>
    <tr>
      <th>Form Rank</th>
      <td><?php echo esc_html($formData['form_rank'] ?? ''); ?></td>
    </tr>
  </table>
</body>

</html>