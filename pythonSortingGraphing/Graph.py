import matplotlib.pyplot as plt
from matplotlib.ticker import ScalarFormatter

import os

# ran this section of code to download matlabplot on whichever environment is run
# didn't know which environment to install it in since the testing and executable
# environments were different, so brute forced it.

'''
import subprocess
# Define the package name you want to install
package_name = 'matplotlib'

# Run pip to install the package
try:
    subprocess.check_call(["pip", "install", package_name])
    print(f"Successfully installed {package_name}")
except subprocess.CalledProcessError as e:
    print(f"Failed to install {package_name}. Error: {e}")'
'''


def main():
    graphSort("insertionSort")
    graphSort("bubbleSort")
    graphSort("heapSort")
    graphSort("mergeSort")
    graphSort("quickSortUnstable")
    graphSort("quickSortStable")
    graphSort("selectionSort")


def graphSort(sort):
    # Get the amount of time it took to complete the sorting
    # list of reads and writes in cpp, in microseconds
    cppReads = []
    cppWrites = []

    # Add time values
    # Push time values C++ took to sort so the cppTimes list
    print("\nLists of reads and writes  ")
    for i in range(1, 11):
        # Open the file
        with open('../data/' + sort + '/output_' + str(i) + '00.txt', 'r') as file:
            next(file)  # Read the first line
            secondline = file.readline()  # Read the second line and split it for the read and write vals
            # Split the line using the space ' ' as the delimiter, with the first part being the number of microsecond
            parts = secondline.split(' ')
            cppReads.append(int(parts[0]))
            cppWrites.append(int(parts[1]))

    print("\n" + sort + "\nReads:\n" + str(cppReads) + "\nWrites:\n" + str(cppWrites))

    #  Graph the results for Insertion sort
    x = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000]  # X-axis values (Vector size)
    y1 = cppReads  # Y-axis values for Reads
    y2 = cppWrites  # Y-axis values for Writes

    # Plotting the data
    plt.plot(x, y1, label='Reads')  # Plot data set 1
    plt.plot(x, y2, label='Writes')  # Plot data set 2

    # Annotate each line with its value
    for line in zip(y1, cppReads):
        plt.text(x[9], y1[9], y1[9],
                 ha='center', va='bottom')

    for line in zip(y2, cppWrites):
        plt.text(x[9], y2[9], y2[9],
                 ha='center', va='bottom')

    # Create a list of the sizes to use for the x-axis tick marks for objects sorted
    sizes = range(100, 1001, 100)
    # Adding labels and legend
    plt.xlabel('Vector Size')
    # Make sure the x-axis tick marks/labels are at each 100
    plt.xticks(sizes)
    plt.ylabel('Number of Reads and Writes')
    plt.legend()

    # Get the current y-axis
    y_axis = plt.gca().yaxis

    # Use ScalarFormatter to format the y-axis ticks in scientific notation
    formatter = ScalarFormatter(useMathText=True)

    # Apply the formatter to the y-axis
    y_axis.set_major_formatter(formatter)

    # Set the window title
    plt.gcf().canvas.manager.set_window_title('C++ ' + sort)
    # Set the graph title
    plt.title('C++ ' + sort + ': Reads and Writes')

    # Creating the image and placing it in the images folder
    # Specify the directory name
    directory_name = "../images"

    # Check if the directory doesn't already exist
    if not os.path.exists(directory_name):
        # Create the directory
        os.makedirs(directory_name)
        print(f"Directory '{directory_name}' created successfully.")

    # Save the graph to a file
    plt.savefig('../images/' + sort + 'C++.png')

    # Display the plot
    plt.show()


if __name__ == '__main__':
    main()
