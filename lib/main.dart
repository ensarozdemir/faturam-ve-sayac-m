import 'package:qr_code/imports_screens.dart';

void main() async {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: AppConstant.app_name,
      theme: ThemeData(
        primarySwatch: Colors.blue,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      initialRoute: AppConstant.splash,
      routes: {
        // '/': (context) => SplashScreen(),
        AppConstant.splash: (context) => SplashScreen(),
        AppConstant.login: (context) => LoginPage(),
        AppConstant.home: (context) => HomeScreen(),
        AppConstant.bottomnavigationscreen: (context) =>
            BottomNavigationScreen(),
        AppConstant.qr_list: (context) => QRCodeListScreen(),
        // AppConstant.qr_scanner: (context) => QRCodeScannerScreen(),
      },
    );
  }
}
