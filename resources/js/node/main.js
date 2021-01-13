const express = require('express');
const router = require('express').Router();
const nightwatch = require('nightwatch');
const config = require('../../../nightwatch.conf.js');
const app = express();
app.use(express.json());

router.get('/get-camera', async (request, response) => {
  try {
   // await getSnapshot(request.body.state, request.body.id);
    await getSnapshot(1);
  } catch (e) {
    console.log(e);
  }
  return response.status(200).json('{}');
});

app.use('/', router);

const server = app.listen(3000);
server.setTimeout(30 * 1000);


app.use(express.json());

async function getSnapshot (id) {
  return new Promise((resolve, reject) => {
    try {
      nightwatch.cli(function (argv) {
        config.test_settings.cameraId = id;
        argv._source = [`./resources/js/vision/snapshot.js`];
        const runner = nightwatch.CliRunner(argv);
        runner
          .setup(config)
          .startWebDriver()
          .catch(err => {
            resolve();
          })
          .then(() => {
            return runner.runTests();
          })
          .catch(err => {
            resolve();
          })
          .then(() => {
            runner.stopWebDriver();
            resolve();
          })
          .catch(err => {
            resolve();
          });
      });
    } catch (err) {
      resolve();
    }
  });
}