# DMZ VM, Connects to Alpaca Trade API
All the dmz box's files live here, namely dmzServer.php, the assorted scripts kept in /scripts, as well as the bots which live in this top folder so they can access the python venv they need to run.



### Configuring a fresh VM to run this code.
### Setting up the DMZ VM with tensorflow and friends

### Create a new VM, stock it with plenty of HDD space, at least 18 GB of RAM and at least 8 cores for compiling TF from source. Can scale back afterwards.

### install python3 deps
sudo apt update
sudo apt install python3-dev python3-pip python3-venv

### create python venv
python3 -m venv --system-site-packages ./venv

### upgrade pip, then we move to compiling from source. Regular TF pip package is fine for the host, but the FMA CPU flag does not show on the VM boxes.
pip install --upgrade pip

# Building from source.

### install tf pip deps
pip install -U pip numpy wheel
pip install -U keras_preprocessing --no-deps

### install bazel for build
sudo apt update && sudo apt install bazel-3.1.0

### clone tf repo
git clone https://github.com/tensorflow/tensorflow.git

cd tensorflow

### While in venv, during configure.py select no for OpenCL, ROCm,CUDA, TensorRT, Clang, default for optimization flags, no for android builds. 
python3 configure.py

### Build the pip package with bazel, This will take a LOT of RAM and run for over an hour, get a snack. Only for CPU support
bazel build //tensorflow/tools/pip_package:build_pip_package

### build the wheel package
./bazel-bin/tensorflow/tools/pip_package/build_pip_package --nightly_flag /tmp/tensorflow_pkg

### install wheel package to pip
pip install /tmp/tensorflow_pkg/tensorflow-[version-tags].whl

### now cd up and out of the tf git directory before testing with 
python -c "import tensorflow as tf;print(tf.reduce_sum(tf.random.normal([1000, 1000])))"

### other python packages needed
pip install twilio yahoo-fin alpaca-trade-api requests-html configparser matplotlib


