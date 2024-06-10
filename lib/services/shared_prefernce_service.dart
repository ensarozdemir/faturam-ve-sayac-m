import 'package:qr_code/imports_screens.dart';

class SharedPreferencesService {
  static Future<void> saveUserLogin(bool login) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setBool('isLogin', login);
  }

  static Future<bool> getUserLogin() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    return prefs.getBool('isLogin') ?? false;
  }

  static Future<void> saveUserTc(String tc) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setString('tc', tc);
  }

  static Future<String?> getUserTc() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    return prefs.getString('tc');
  }

  static Future<void> logoutUser() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setBool('isLogin', false);
    await prefs.remove('tc');
  }
}
