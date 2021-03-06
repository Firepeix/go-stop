const express = require('express');
const router = require('express').Router();
const nightwatch = require('nightwatch');
const config = require('../../../nightwatch.conf.js');
const app = express();
app.use(express.json());
router.post('/get-camera', async (request, response) => {
  try {
    console.log(`Novo Request ID: ${request.body.id} Session ID: ${request.body.sessionId}`);
    await getSnapshot(request.body.id, request.body.sessionId, request.body.frames);
    console.log('Finalizado');
  } catch (e) {
    console.log(e);
  }
  return response.status(200).json('{ "success": true }');
});

app.use('/', router);

const server = app.listen(3000);
server.setTimeout(30 * 1000);


app.use(express.json());

async function getSnapshot (id, sessionId, frames) {
  return new Promise((resolve, reject) => {
    try {
      nightwatch.cli(function (argv) {
        config.test_settings.cameraId = id;
        config.test_settings.cameraSessionId = sessionId;
        config.test_settings.frames = frames;
        argv._source = [`./resources/js/vision/snapshot.js`];
        const runner = nightwatch.CliRunner(argv);
        runner
          .setup(config)
            .startWebDriver()
            .catch(err => {
              resolve();
              console.log(err);
            })
            .then(() => {
              return runner.runTests();
            })
            .catch(err => {
              console.log(err);
              resolve();
            })
            .then(() => {
              runner.stopWebDriver();
              resolve();
            })
            .catch(err => {
              console.log(err);
              resolve();
            });
      });
    } catch (err) {
      console.log(err);
      resolve();
    }
  });
}
