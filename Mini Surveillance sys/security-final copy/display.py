import motionLedBuzz

# display file


def main():
    print("\n\n\n\n\n\n\n\n\n\n\n")
    print("************************************************************************************************************************************************************************************************************")
    for x in range(16):
        print("*                                                                                                                                                                                                          *")
    print("*                                                                                                  WELCOME TO STEVEN'S                                                                                     *")
    print("*                                                                                                 MINI SECURITY SYSTEM                                                                                     *")
    for x in range(16):
        print("*                                                                                                                                                                                                          *")
    print("************************************************************************************************************************************************************************************************************")
    print("\n\n\n\n\n\n\n\n\n\n\n")
    if input('Would you like to initialize the security system?: (y/n)\n') == 'y':
        print("Security system running now...\n")
        motionLedBuzz.main()
    else:
        print('Goodbye then!')
        return False

if __name__ == '__main__':
    main()
