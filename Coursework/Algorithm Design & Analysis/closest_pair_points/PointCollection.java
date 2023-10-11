// jdh Spring 2023 CS224

import java.util.List;
import java.util.ArrayList;
import java.lang.*;


public class PointCollection {
    List<Point> points;
    Point y_arr[];
    int origN;

    //--------------------------------------------------------------

    public PointCollection() {
        points = new ArrayList<Point>();
    }

    //--------------------------------------------------------------

    void addPoint(Point p) {
        points.add(p);
    }

    //--------------------------------------------------------------

    PointPair closestPairRec(List<Point> Px, List<Point> Py) {
        // implement this function
        // base case
        if (Px.size() <= 3 && Py.size() <= 3) {
            // compute closest pair using brute force
            double minDistance = Double.MAX_VALUE;
            PointPair minPair = null;
            for (int i = 0; i < Px.size(); i++) {
                for (int j = 0; j < Py.size(); j++) {
                    if (Px.get(i) != Py.get(j)) {
                        double distance = Px.get(i).distanceTo(Py.get(j));
                        if (minDistance > distance) {
                            minDistance = distance;
                            minPair = new PointPair(Px.get(i), Py.get(j));
                        }
                    }
                }
            }

            return minPair;
        }


        // constructing Qx Rx Qy Ry
        List<Point> Qx = new ArrayList<>();
        for (int i = 0; i < Px.size() / 2; i++) {
            Qx.add(Px.get(i));
        }
        List<Point> Rx = new ArrayList<>();
        for (int i = Px.size() / 2; i < Px.size(); i++) {
            Rx.add(Px.get(i));
        }


        List<Point> Qy = new ArrayList<>();
        List<Point> Ry = new ArrayList<>();
        for (int i = 0; i < Py.size(); i++) {
            // if Qy point in Qx, add in order of Qy, else add to Ry
            if (Qx.contains(Py.get(i))) {
                Qy.add(Py.get(i));
            } else {
                Ry.add(Py.get(i));
            }
        }

        // constructing point pairs from recursive call with Qx Rx Qy Ry
        PointPair leftPP = closestPairRec(Qx, Qy);
        PointPair rightPP = closestPairRec(Rx, Ry);

        // constructing delta
        double delta = Math.min(leftPP.p1.distanceTo(leftPP.p2), rightPP.p1.distanceTo(rightPP.p2));
        // constructing x star

        // largestQyX is double representing the largest x in Qy
        // largestQxX is double representing largest x in Qx, which is just the last index since sorted
        double largestQyX = 0;
        double largestQxX = Qx.get(Qx.size() - 1).x;
        for (int i = 0; i < Qy.size(); i++) {
            if (largestQyX < Qy.get(i).x) {
                largestQyX = Qy.get(i).x;
            }
        }
        double xStar = Math.max(largestQxX, largestQyX);

        // constructing Sy
        // 𝑆 is the list of points from 𝑃, that are within 𝛿 units in the 𝑥 direction of 𝑥∗
        List<Point> Sy = new ArrayList<>();
        for (int i = 0; i < Py.size(); i++) {
            if (Py.get(i).x >= (Math.abs(xStar - delta)) && Py.get(i).x <= xStar + delta) {
                Sy.add(Py.get(i));
            }
        }

        if (Sy.size() > 1) {

            // REAL SOLN O(N) TIME I THINK
            double minDistance = Double.MAX_VALUE;
            int j;
            int minI = 0;
            int minJ = 0;

            for (int i = 0; i < Sy.size(); i++){
                if (Sy.size()-1 <= i+15){
                    j = Sy.size()-1;
                } else {
                    j = i+15;
                }
                for (int k = 1; k <= j; k++){
                    if (minDistance > Sy.get(i).distanceTo(Sy.get(j-k)) && i != j-k){
                        minDistance = Sy.get(i).distanceTo(Sy.get(j-k));
                        minI = i;
                        minJ = j-k;
                    }
                }
            }

           /* // TEMP SOL BRUTE FORCE
            double minDistance = Double.MAX_VALUE;
            int minI = 0;
            int minJ = 0;
            for (int i = 0; i < Sy.size(); i++) {
                for (int j = 0; j < Sy.size(); j++) {
                    if (Sy.get(i) != Sy.get(j)) {
                        if (minDistance > Sy.get(i).distanceTo(Sy.get(j))) {
                            minDistance = Sy.get(i).distanceTo(Sy.get(j));
                            minI = i;
                            minJ = j;
                        }
                    }
                }
            }*/
            //return new PointPair(points.get(minI), points.get(minJ));
            PointPair sPoints = new PointPair(Sy.get(minI), Sy.get(minJ));
            // final return statements
            if (sPoints.p1.distanceTo(sPoints.p2) < delta) {
                return sPoints;
            }
        }


        if (leftPP.p1.distanceTo(leftPP.p2) < rightPP.p1.distanceTo(rightPP.p2)) {
            return leftPP;
        } else {
            return rightPP;
        }
    } // closestPairRec()

    //--------------------------------------------------------------

    PointPair closestPair() {
        // implement this function

        // sort points by x
        List<Point> Px = new ArrayList<>();
        for (int i = 0; i < points.size(); i++) {
            Px.add(points.get(i));
        }
        Px.sort(Point::compareX);

        // saving position in xpos and ypos
        for (int i = 0; i < Px.size(); i++) {
            Px.get(i).xpos = i;
        }


        // sort points by y
        List<Point> Py = new ArrayList<>();
        for (int i = 0; i < points.size(); i++) {
            Py.add(points.get(i));
        }
        Py.sort(Point::compareY);

        // saving position in xpos and ypos
        for (int i = 0; i < Py.size(); i++) {
            Py.get(i).ypos = i;
        }

        // call closestPairRec()
        PointPair pointPair = closestPairRec(Px, Py);
        return pointPair;
    } // closestPair()

    //--------------------------------------------------------------

    PointPair bruteForce() {
        // implement this function
        double distance = 0;
        double minDistance = Double.MAX_VALUE;
        int minI = 0;
        int minJ = 0;
        for (int i = 0; i < points.size(); i++) {
            for (int j = 0; j < points.size(); j++) {
                if (points.get(i) != points.get(j)) {
                    distance = points.get(i).distanceTo(points.get(j));
                    if (minDistance > distance) {
                        minDistance = distance;
                        minI = i;
                        minJ = j;
                    }
                }
            }
        }
        return new PointPair(points.get(minI), points.get(minJ));

    } // bruteForce()
}

