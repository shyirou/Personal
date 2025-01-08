const { exec } = require('child_process');

module.exports = (req, res) => {
  exec('php ./public/index.php', (err, stdout, stderr) => {
    if (err) {
      return res.status(500).send(`Error: ${stderr}`);
    }
    res.status(200).send(stdout);
  });
};
