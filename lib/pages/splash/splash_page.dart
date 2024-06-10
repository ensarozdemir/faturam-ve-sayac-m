import 'package:qr_code/imports_screens.dart';

class SplashScreen extends StatefulWidget {
  @override
  _SplashScreenState createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  void initState() {
    super.initState();
    checkLoginStatus();
  }

  void checkLoginStatus() async {
    // Delay for 3 seconds
    await Future.delayed(Duration(seconds: 3));
    // Fetch user login status from SharedPreferences
    bool isLoggedIn = await SharedPreferencesService
        .getUserLogin(); // Ensure this method is asynchronous
    if (isLoggedIn) {
      Navigator.of(context).pushReplacementNamed('/bottomnavigationscreen');
    } else {
      Navigator.of(context).pushReplacementNamed('/login');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            // Replace with your app's logo or another graphic element
            Image.asset(ImagesConstant.logo),
            const SizedBox(height: 20),
            const Text(
              AppConstant.app_name,
              style: bold22Primary,
            ),
          ],
        ),
      ),
    );
  }
}
