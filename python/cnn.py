import os
import itertools
import numpy as np
import pandas as pd
import cv2
from matplotlib import pyplot as plt

# Set paths for train and test data on your PC
train_path = r'C:\PROJECT\dataset\Alzheimer_s Dataset\train'
test_path = r'C:\PROJECT\dataset\Alzheimer_s Dataset\test'
data = []
CLASSES = [ 'NonDemented',
            'VeryMildDemented',
            'MildDemented',
            'ModerateDemented']

for trainpath in os.listdir(train_path):
   print(trainpath)
   for tr in os.listdir(train_path + "/" + trainpath):
       img = cv2.imread(train_path + "/" + trainpath + "/" + tr)
       img = cv2.resize(img, (32, 32))
       img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
       img = img.reshape(32, 32, 1)
       img = img / 255.0  # Scale the pixel values


       data.append([img, trainpath])

for testpath in  os.listdir(test_path):
    print(testpath)
    for ts in os.listdir(test_path + "/" + testpath):
        img = cv2.imread(test_path+ "/" + testpath + "/" + ts)
        img = cv2.resize(img, (32, 32))
        img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        img = img.reshape(32, 32, 1)
        img = img / 255.0  # Scale the pixel values

        data.append([img, testpath])

x, y = [], []
for e in data:
    x.append(e[0])
    y.append(e[1])


from sklearn.preprocessing import OneHotEncoder

x = np.array(x)
y = np.array(y)
y = y.reshape(y.shape[0],1)
enc = OneHotEncoder(handle_unknown='ignore').fit(y)
y_train_encoded = enc.transform(y).toarray()
y_test_encoded = enc.transform(y).toarray()
print(enc.categories_)
y = enc.transform(y).toarray()

print(f'Data   :   {str(x.shape)}')
print(f'Labels :   {str(y.shape)}')

from sklearn.model_selection import train_test_split

x_train, x_test, y_train_encoded, y_test_encoded = train_test_split(x, y, random_state=1, test_size=0.2)

import tensorflow as tf
gpus = tf.config.experimental.list_physical_devices('GPU')
for gpu in gpus:
    tf.config.experimental.set_memory_growth(gpu, True)
print(tf.config.list_physical_devices('GPU'))

from tensorflow import keras
import keras
from keras.models import save_model

from keras import Sequential
from keras.layers import Dense,Conv2D,MaxPooling2D,Flatten,Dropout, BatchNormalization
from keras.preprocessing.image import ImageDataGenerator


model = tf.keras.Sequential([
    tf.keras.layers.Conv2D(64, (4, 4), padding='same', activation=tf.nn.relu,
    input_shape=(32, 32, 1)),
    tf.keras.layers.MaxPooling2D((2, 2), strides=(2,2)), Dropout(0.25),

    tf.keras.layers.Conv2D(128, (3,3), padding='same', activation=tf.nn.relu),
    tf.keras.layers.MaxPooling2D((2, 2), strides=(2,2)),
    Dropout(0.25),

    tf.keras.layers.Conv2D(128, (3,3), padding='same', activation=tf.nn.relu),
    tf.keras.layers.MaxPooling2D((2, 2), strides=(2,2)),
    Dropout(0.3),

    tf.keras.layers.Conv2D(128, (2,2), padding='same', activation=tf.nn.relu),
    tf.keras.layers.MaxPooling2D((2, 2), strides=(2,2)),
    Dropout(0.3),

    tf.keras.layers.Conv2D(256, (2,2), padding='same', activation=tf.nn.relu),
    tf.keras.layers.MaxPooling2D((2, 2), strides=(2,2)),
    Dropout(0.3),

    tf.keras.layers.Flatten(),
    tf.keras.layers.Dense(128, activation=tf.nn.relu),
    tf.keras.layers.Dense(4,  activation=tf.nn.softmax)
])
model.summary()

model.compile(optimizer='Adam', loss='categorical_crossentropy', metrics=['accuracy'])

model.compile(optimizer='Adam',loss='categorical_crossentropy',metrics=['accuracy'])

# Using y_train_encoded and y_test_encoded
hist = model.fit(x_train, y_train_encoded, epochs=100, validation_data=(x_test, y_test_encoded), batch_size=64, verbose=1, shuffle=True)
model.save('Alzheimer_PROJECT_CNN.h5')

fig = plt.figure(figsize=(12, 6), dpi=80)
plt.plot(hist.history['accuracy'], color='teal', label='accuracy')
plt.plot(hist.history['val_accuracy'], color='orange', label='val_accuracy')
fig.suptitle('Accuracy', fontsize=20)
plt.legend(loc="upper left")
plt.show()

loss_and_metrics = model.evaluate(x_test, y_test_encoded, verbose=2)
y_pred = model.predict(x_test).argmax(axis=1)
print(f'Test Loss     : {loss_and_metrics[0]}')
print(f'Test Accuracy : {loss_and_metrics[1]}')
print(y_test_encoded.shape, y_pred.shape)



